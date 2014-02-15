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
           
            //$this->beforeFilter('csrf',array('on'=>'login'));
        
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
            $phones = Phone::orderBy('created_at','ASC')->get();
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
        public function login()
        {
            // Si hay una peticion en el request comprobara los datos de la peticion
            // si odo esta correcto, logueara al usuario
            if(Request::all())
            {
                
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
                
            }
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
                // EL ERROR ESTA EN EL VALIDATOR CON LA INFORMACION
                /*$pass = Validator::make(Input::get('username'),$user::$rules);
                if($pass->fails()){
                    return Response::json('ha fallado');
                }*/
                return Response::json(Request::get('username'));
            }
            // Si hay una peticion en el request comprobara los datos de la peticion
            if(Request::all()){
                // instancio el modelo User
                $user = new User();
                // Comprueb que los datos son validos con el Validatos::make
                // pasandole los datos de request::all con las reglas generadas en el modelo de User
                $pass = Validator::make(Request::all(),$user::$rules);
                // Si ha fallado la validacion, lo redirecciona al formulario con los errores
                if($pass->fails()){
                    return Redirect::to('register')->withErrors($pass);
                }
                // Si todo sale bien, inserta el usuario en la base de datos
                // y lo redirige al formulario de login con un mensaje
                else{
                    $user->name = Input::get('username');
                    $user->password = Hash::make(Input::get('password'));
                    $user->email = Input::get('email');
                    if($user->save()){
                       return Redirect::to('login')->with('message','El usuario ha sido registrado');
                    }
                    //return Redirect::to('registro')->with('message', 'Todo correcto');
                }
              
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
            return Redirect::to('/');
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
                    $phones = Phone::all();
                }
                else{
                    // Obtengo los telefonos que tengan cuya id_brand es la id enviada
                    $phones = Brand::find(Input::get('id'))->phones;
                }
                
                // Genero la vista a enviar para responder a la peticion ajax.
                // Es un html
                $view = View::make('ajax/phones/show')->with('phones',$phones);
                
                // devuelvo la vista
                return $view;
            }
            
            
            // Obtengo todos los telefonos y todas las marcas
            // Esta informacion sera obtenida SOLO cuando no sea una peticion ajax
            $phones = Phone::all();
            $brands = Brand::all();
            
            // devuelvo las vistas. Esta vista SOLO sera pasada cuando no sea una peticion ajax
            return $view = View::make('showPhones')
                    ->with('phones',$phones)
                    ->with('brands',$brands);
                   
        }
        
        public function changePassword(){
            
            
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
                        }  
                    }
                    
                    return array(
                        'save'=>false,
                        'data'=>
                            array(
                                'error'=>$pass->messages()->toArray()
                            ),
                        'message'=>'Hay algun dato mal'
                        );
                    
                }
            
            
                if(Request::all()){
                    // INTENTAR CAMBIARLO CON EL VALIDADOR
                    // NO CONSIGO QUE ME VALIDE 
                    //if(Validator::make(Request::all(),User::$rulesChangePassword)){
                        
                        /*if(Input::get('newPassword') == Input::get('repeatPassword')){
                            $user = User::find(Auth::user()->id);
                           
                            $user->password = Hash::make(Input::get('newPassword'));
                            if($user->save()){
                                return Redirect::to('profile')->with('message','La contraseña ha dido cambiada');
                            }
                            else{
                                return Redirect::to('changePassword')->with('message','No a poddo guardar');
                            }
                        }
                        else{
                            return Redirect::to('changePassword')->with('message','nuevas contraseñas no coinciden');
                        }*/
                    //}
                    /*$pass = Validator::make(Request::all(),User::$rules);
                    
                    if(!$pass->fails()){
                        $user = User::find(Auth::user()->id);
                        if(Hash::check(Input::get('oldPassword'),$user->password)){
                            
                            $user->password = hash::make(Input::get('newPassword'));
                            
                            if($user->save()){
                                return Redirect::to('profile')->with('message','La contraseña ha dido cambiada');
                            }
                        }  
                    }
                    
                    return Redirect::to('changePassword')->
                            with('message','No se ha podido cambiar la contraseña')->
                            withErrors($pass);*/
                    
                   
                }
                
                
                
            
            
            //return View::make('profile/changePassword');
            
        }
        
        
        public function changeEmail(){
            
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
                }
                
                
                return array(
                        'save'=>false,
                        'data'=>
                            array(
                                'error'=>$pass->messages()->toArray()
                            ),
                        'message'=>'Hay algun dato mal'
                        );
            }
            
            /*if(Request::all()){
                // INTENTAR CAMBIARLO CON EL VALIDADOR
                // NO CONSIGO QUE ME VALIDE 
                // MISMO PROBLEMA QUE changePassword
                // RECUERDA Validator::make(Request::all(),User::$rulesChangeEmail) SIEMPRE DEVULVE TRUE VALIE O NO VALIDE
                $pass = Validator::make(Request::all(),User::$rules);
                
                if(!$pass->fails()){
                    
                    $user = User::find(Auth::user()->id);
                    $user->email = Input::get('email');
                    if($user->save()){
                        return Redirect::to('profile')->with('message','El correo ha sido cambiado');
                    }
                }
                else{
                    
                    return Redirect::to('changeEmail')->withErrors($pass);
                    
                }
                
                
                     
            }*/
            //return View::make('profile/changeEmail');
        }
        
        public function deleteUser(){
            
            User::destroy(Auth::user()->id);
            return Redirect::to('/')->with('message','El usuario ha sido borrado');
            
        }
}