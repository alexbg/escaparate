<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
       
    /**
     * EL csrf
     */
       public function __construct() {
           
            $this->beforeFilter('csrf',array('on'=>'login'));
        
       }

	public function showWelcome(){
            
            return View::make('hello');
                
	}
        /**
         * Muestra la pagina principal donde se mostraran los ultimos
         * telefonos añadidos
         * 
         * @return type View
         */
        public function index(){
            // Obtengo los telefonos ordenados de forma ascendente
            $phones = Phone::orderBy('created_at','ASC')
                    ->paginate(2);
            // Genero la vista index que es la principal
            $view = View::make('index');
            // Añado una vista shopWindow si hay algun telefono añadido 
            if($phones != null){
                $view->nest('shopWindow','shopWindow',array('phones'=>$phones));
            }
            // retorno la vista
            return $view;
            
        }
        
        /**
         * Permite loguearse al usuario
         * @return type
         */
        public function login(){
            // Si hay una peticion en el request comprobara los datos de la peticion
            // si odo esta correcto, logueara al usuario
            
            if(Request::ajax()){
                
                //return View::make('ajax/menu/login');
                $message = 'El usuario o la contraseña son incorrectos';
                // Comprueba que los datos sean correctos en la base de datos de User y lo loguea si ha salido correcto
                // Cuando termina todo, redirecciona al usuario con un mensaje
                if(!Auth::attempt(array('email'=>Input::get('email'),'password'=>Input::get('password')),true)){
                    // Si hay algo mal, envia un mensaje al usuario mediante with('message'
                    //return Redirect::to('login')->with('message','El usuario o la contraseña son incorrectos');
                    return array(
                        'save'=>false,
                        'message'=>$message,
                        );
                }
                else{
                    // Si todo ha salido bien y el usuario esta logueado, envia un mensaje al usuario con with('message'
                    //return Redirect::to('/')->with('message','has sido logueado');
                    $message = 'Redirigiendo a la pagina principal...';
                    Session::flash('message','has sido logueado');
                     return array(
                        'save'=>true,
                        'message'=>$message,
                        'redirect'=>url('/')
                        );
                    
                }
            }
            
           
            /*if(Request::all()){  
                // Comprueba que los datos sean correctos en la base de datos de User y lo loguea si ha salido correcto
                // Cuando termina todo, redirecciona al usuario con un mensaje
                if(!Auth::attempt(array('email'=>Input::get('email'),'password'=>Input::get('password')),true)){
                    // Si hay algo mal, envia un mensaje al usuario mediante with('message'
                    return Redirect::to('login')->with('message','El usuario o la contraseña son incorrectos');
                }
                else{
                    // Si todo ha salido bien y el usuario esta logueado, envia un mensaje al usuario con with('message'
                    return Redirect::to('/')->with('message','has sido logueado');
                }
            }*/
                
            
            // devuelve la primera vez el formulario de login
            return View::make('forms/login'); 
               
        }
        
        /**
         * Permite registrar un usuario en la base de datos User
         * @return type
         */
        public function register()
        {
            
            if(Request::ajax()){
                // Si hay una peticion en el request comprobara los datos de la peticion
                $message;
                // instancio el modelo User
                $user = new User();
                // Comprueba que los datos son validos con el Validatos::make
                // pasandole los datos de request::all con las reglas generadas en el modelo de User
                
                $pass = Validator::make(Request::all(),$user::$rules);
                // Si ha fallado la validacion, lo redirecciona al formulario con los errores
                if(!$pass->fails()){
                    //return Redirect::to('register')->withErrors($pass);
                    $user->name = Input::get('username');
                    $user->password = Hash::make(Input::get('password'));
                    $user->email = Input::get('email');
                    $user->date = Input::get('day').'/'.Input::get('month').'/'.Input::get('year');
                    $user->address = Input::get('address');
                    $user->phone_number = Input::get('phone');
                    if($user->save()){
                        // informo al usuario de que esta siendo redirigido al login
                        $message = 'Usuario guardado. Redirigiendo al login...';
                        // mostrare el mensaje de que ha sido logueado
                        Session::flash('message','Usuario registrado, ya puede loguearse');
                        // devuelvo la informacion necesaria al ajax que esta esperando
                        return array(
                            'save'=>true,
                            'message'=>$message,
                            'redirect'=>url('/login')
                        );
                    }
                    else{
                        $message = 'Ahora no puede registrarse, intentelo mas tarde';
                    }
                }
                // Si todo sale bien, inserta el usuario en la base de datos
                // y lo redirige al formulario de login con un mensaje
                $message = 'Los datos introducidos no son validos';
                return array(
                        'save'=>false,
                        'message'=>$message,
                        'data'=>array(
                                'error'=>$pass->messages()->toArray()
                        ),
                );
            }
            
            
            // devuelve el formulario de login
            return View::make('forms/register');
            
        }
        
        /**
         * Permite desloguear al usuario que esta logueado
         * @return type
         */
        public function logout()
        {
            Auth::logout();
            return Redirect::to('/')->with('message','Has sido deslogueado');
        }
        
        /**
         * Muestra la informacion de perfil del usuario logueado
         * @return type
         */
        public function profile(){
            // Encuentro el usuario en la base de datos
            $user = User::find(Auth::user()->id);
            // POR AHORA FUNCIONA PERO BUSCAR UNA MANERA DE HACERLO CON LA RELACION de belongsTo
            // QUIERO ORDENARLOS DE MANERA DESC Y QUE SOLO OBTENGA 10 COMENTARIOS
            $comments = Comment::where('id_user',$user->id)
                    ->orderBy('created_at','DESC')
                    ->paginate(10);
            
            // devuelvo la vista con la informacion necesaria
            return View::make('profile/showProfile')
                    ->with('user',$user)
                    ->with('comments',$comments);
            
        }
        
        /**
         * Muestra los telefono. Si el usuario quiere que se muestre los telefonos de una marca
         * Se enviara la id de la marca mediante get y se pasa como parametro a esta funcion.
         * Separo la busqueda de las marcas y de los telefonos para poder generar el menu de la izquierda
         * en la vista showPhones. Envio el id de la marca para poder activar con boostrap la amrca
         * que ha señalado el usuario en la tabla de la izquierda de showPhones 
         * @param type $idBrand
         * @return type
         */
        public function showPhones($idBrand = null){
            
            /*$phones = null;
            $view;*/
            
            // SI hay una peticion ajax entonces ejecutara lo que esta dentro
            if(Request::ajax()){
                
                // Si en la peticion no hay un dato llamado id, 
                // entonces obtendra todos los telefonos. 
                // EN caso contrario, devolvera los telefonos cuya marca 
                // a la que pertenecen tienen el id enviado
                if(!Input::get('id')){
                    $phones = Phone::orderBy('created_at','DESC')->paginate(1);
                    
                }
                else{
                    // Obtengo los telefonos que tengan cuya id_brand es la id enviada
                    
                    $phones = Brand::find(Input::get('id'))->phones;
                    
                }
                
                // Genero la vista a enviar para responder a la peticion ajax.
                // Es un html
                $view = View::make('ajax/phones/show')
                        ->with('phones',$phones);
                
                // devuelvo la vista
                return $view;
            }
            
            
            // Obtengo todos los telefonos y todas las marcas
            // Esta informacion sera obtenida SOLO cuando no sea una peticion ajax
            $phones = Phone::OrderAsc()->paginate(1);
            $brands = Brand::all();
            
            // devuelvo las vistas. Esta vista SOLO sera pasada cuando no sea una peticion ajax
            return $view = View::make('showPhones')
                    ->with('phones',$phones)
                    ->with('brands',$brands);
                   
        }
        
        public function changePassword(){
            
                $message = 'Hay algun error';
            
                if(Request::ajax()){
                    
                    //$inputs = json_decode(Request::all());

                    $pass = Validator::make(Request::all(),User::$rules);

                    if(!$pass->fails()){
                        $user = User::find(Auth::user()->id);
                        if(Hash::check(Input::get('oldPassword'),$user->password)){

                            $user->password = hash::make(Input::get('newPassword'));

                            if($user->save()){

                               return array('save'=>true,'message'=>'La contraseña a sido cambiada');
                            }
                            else
                            {
                                $message = 'La password no puede ser modificada';
                            }
                        }
                        else{
                            $message = 'Tu antiguo password no es correcto';
                        } 
                    }
                    else{
                        $message = 'Alguno de los datos es incorrecto';
                    }
                    
                    return array(
                        'save'=>false,
                        'data'=>
                            array(
                                'error'=>$pass->messages()->toArray()
                            ),
                        'message'=>$message
                        );
                }
        }
        
        
        public function changeEmail(){
            
            $message = 'Hay algun error';
            
            if(Request::ajax()){
                
                $pass = Validator::make(Request::all(),User::$rules);
                
                if(!$pass->fails()){
                    
                    $user = User::find(Auth::user()->id);
                    $user->email = Input::get('email');
                    if($user->save()){
                        /**
                         * SOLO SAVE ES OBLIGATORIO
                         * save: sirve para indicar si hay algun erro o no
                         * message: sirve para enviar un mensaje con alguna informacion
                         * type: sirve para indicar el tipo de informacion que usas o estas modificando(password,email,etc)
                         *  y de esta forma personalizar mas el resultado de ajax
                         * data: datos a enviar. Puede ser un array o lo que quieras
                         * En este caso es 'data'=>
                            array(
                                'error'=>$pass->messages()->toArray()
                            ),
                        'message'=>'Hay algun dato mal'
                         */
                        return array(
                            'save'=>true,
                            'message'=>'El email ha sido cambiado',
                            'type'=>'email',
                            'data'=>Input::get('email')
                        );
                    }
                    else{
                        $message = 'El Correo elecronico no puede ser modificado';
                    }
                }
                else{
                    $message = 'Alguno de los datos es incorrecto';
                }
                
                
                return array(
                        'save'=>false,
                        'data'=>
                            array(
                                'error'=>$pass->messages()->toArray()
                            ),
                        'message'=>$message,
                        );
            }
        }
        
        public function changeLanguage(){
            
            //(Input::get('language'));
            Session::put('my.locale', Input::get('language'));
            
            return Redirect::to('profile')->with('message','El idioma a sido cambiado');
            
            /*return array(
                        'save'=>true,
                        'message'=>'El idioma a sido cambiado',
                        'data'=>Input::get('language'),
                        'type'=>'language'
                        );*/
            
        }
        
        /**
         * Permite cambiar alguna informacion del usuario
         * @return type
         */
        public function changeInformation(){
            
            // Encuentra al usuario logueado
            $user = User::find(Auth::user()->id);
            
            // Escribe el primer mensaje que puede ser enviado en respuesta al ajax
            $message = 'La informacion no es correcta';
            
            // obtengo el nombre del valor que quiero cambiar
            $name = Input::get('name');
            
            // obtengo el valor
            $value = Input::get('value');
            
            // depende del nombre, asi cambiare algun dato del usuario
            switch($name){
                
                case 'date':
                    $user->date = $value;
                    break;
                case 'email':
                    $user->email = $value;
                    break;
                case 'phone':
                    $user->phone_number = $value;
                    break;
                case 'address':
                    $user->address = $value;
                    break;
    
            };
            
            if($user->save()){
                // Si ha sido guardado con exito, cambio informacion del usuario que
                // esta logueado
                switch($name){
                
                    case 'date':
                        Auth::user()->date = $user->date;
                        break;
                    case 'email':
                        Auth::user()->email = $user->email;
                        break;
                    case 'phone':
                        Auth::user()->phone_number = $user->phone_number;
                        break;
                    case 'address':
                        Auth::user()->address = $user->address;
                        break;
    
                };
                
                // devuelvo la informacion necesaria para la respuesta del ajax
                return array(
                    'save'=>'true',
                    'message'=>'Se ha modificado la informacion',
                    'data'=>$value,
                );
            }
            else{
                $message = 'El dato introducido no es valido';
            }
            
            return array(
                'save'=>'false',
                'message'=>$message,
            );
            
        }
        
        public function deleteUser(){
            
            User::destroy(Auth::user()->id);
            return Redirect::to('/')->with('message','El usuario ha sido borrado');
            
        }
}