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
            /**
             * Todos tienen que estar logueados excepto login,index,register y showPhones
             */
            $this->beforeFilter('auth',array(
                'except'=>array(
                    'login',
                    'index',
                    'register',
                    'showPhones'
                    )
                )
            );
        
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
                    ->paginate(10);
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
                $message = trans('message.login.wrong');
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
                    
                    // pongo el idioma que tiene el usuario
                    Session::put('my.locale', Auth::user()->language);
                    // pongo el mensaje de redirigir a la pagina principal
                    $message = trans('message.login.well');
                    // guaro un mensaje flash diciendo que ha sido logueado
                    Session::flash('message',trans('message.login.logged'));
                    // paso los valores necesarios a la respuesta del ajax
                     return array(
                        'save'=>true,
                        'message'=>$message,
                        'redirect'=>url('/')
                        );
                    
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
                // Si hay una peticion en el request comprobara los datos de la peticion
                $message = trans('message.error');
                
                // Comprueba que los datos son validos con el Validatos::make
                // pasandole los datos de request::all con las reglas generadas en el modelo de User
                
                $pass = Validator::make(Request::all(),User::$rules);
                // Si ha fallado la validacion, lo redirecciona al formulario con los errores
                if(!$pass->fails()){
                    
                    // instancio el modelo User
                    $user = new User(Request::all());
                    $user->date = Input::get('day').'/'.Input::get('month').'/'.Input::get('year');
                    $user->password = Hash::make(Input::get('password'));
                    if($user->save()){
                        // informo al usuario de que esta siendo redirigido al login
                        $message = trans('message.register.saved');
                        // mostrare el mensaje de que ha sido logueado
                        Session::flash('message',trans('message.register.registered'));
                        // devuelvo la informacion necesaria al ajax que esta esperando
                        return array(
                            'save'=>true,
                            'message'=>$message,
                            'redirect'=>url('/login')
                        );
                    }
                    else{
                        $message = trans('message.errorToSave');
                    }
                }
                // Si todo sale bien, inserta el usuario en la base de datos
                // y lo redirige al formulario de login con un mensaje
                $message = trans('message.register.wrong');
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
         * Permite desloguear al usuario que esta logueado.
         * DEBES ESTAR LOGUEADO
         * @return type
         */
        public function logout()
        {
            Auth::logout();
            return Redirect::to('/')->with('message',trans('message.logout'));
        }
        
        /**
         * Muestra la informacion de perfil del usuario logueado
         * DEBES ESTAR LOGUEADO
         * @return type
         */
        public function profile(){
            // Encuentro el usuario en la base de datos
            $user = User::find(Auth::user()->id);
            // POR AHORA FUNCIONA PERO BUSCAR UNA MANERA DE HACERLO CON LA RELACION de belongsTo
            // QUIERO ORDENARLOS DE MANERA DESC Y QUE SOLO OBTENGA 10 COMENTARIOS
            $comments = Comment::where('id_user',$user->id)
                    ->orderBy('created_at','DESC')
                    ->take(2)->get();
            
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
            $phones = Phone::OrderAsc()->paginate(5);
            $brands = Brand::all();
            
            // devuelvo las vistas. Esta vista SOLO sera pasada cuando no sea una peticion ajax
            return $view = View::make('showPhones')
                    ->with('phones',$phones)
                    ->with('brands',$brands);
                   
        }
        
        public function changePassword(){
            
                $message = trans('message.error');
            
                if(Request::ajax()){
                    
                    //$inputs = json_decode(Request::all());

                    $pass = Validator::make(Request::all(),User::$rules);

                    if(!$pass->fails()){
                        $user = User::find(Auth::user()->id);
                        if(Hash::check(Input::get('oldPassword'),$user->password)){

                            $user->password = hash::make(Input::get('newPassword'));

                            if($user->save()){

                               return array('save'=>true,'message'=>trans('message.changePassword.saved'));
                            }
                            else
                            {
                                $message = trans('message.errorToSave');
                            }
                        }
                        else{
                            $message = trans('message.changePassword.oldPassword');
                        } 
                    }
                    else{
                        $message = trans('message.changePassword.wrong');
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
            
            $message = trans('message.error');
            
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
                            'message'=>trans('message.changeEmail.saved'),
                            'type'=>'email',
                            'data'=>Input::get('email')
                        );
                    }
                    else{
                        $message = trans('message.errorToSave');
                    }
                }
                else{
                    $message = trans('message.changeEmail.wrong');
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
            
            // guardo en la sesion un valor que sera el lenguaje
            Session::put('my.locale', Input::get('language'));
            
            // obtengo el usuario mediante el di almacenado en la sesion
            $user = User::find(Auth::user()->id);
            
            // cambio el lenguaje en el usuario
            $user->language = Input::get('language');
            
            // si los cambios son guardados, se mostrara un mensaje
            if($user->save()){
                return Redirect::to('profile')->with('message',trans('message.changeLanguage.saved'));
            }
            
            // se redirijira cuando los cambios no son guardados
            return Redirect::to('profile')->with('message',trans('message.errorToSave'));
               
        }
        
        /**
         * Permite cambiar alguna informacion del usuario
         * @return type
         */
        public function changeInformation(){
            
            // Encuentra al usuario logueado
            $user = User::find(Auth::user()->id);
            
            // Escribe el primer mensaje que puede ser enviado en respuesta al ajax
            $message = trans('message.changeInformation.wrong');
            
            // pasa la validacion
            $pass = Validator::make(Request::all(),User::$rules);
            
            // si la validacion no ha fallado entra en el if
            if(!$pass->fails()){
                
                 // Encuentra al usuario logueado
                $user = User::find(Auth::user()->id);
                // variable que almacenara la informacion a devolver a la pagina
                $send;
                
                // Si hay alguna de las siguientes situaciones, entonces cambiara
                // la informacion
                switch(array_keys(Request::all())[0]){
                    case 'date':
                        $user->date = Input::get('date');
                        $send = $user->date;
                        break;
                    case 'phone':
                        $user->phone = Input::get('phone');
                        $send = $user->phone;
                        break;
                    case 'address':
                        $user->address = Input::get('address');
                        $send = $user->address;
                        break;
                    case 'url':
                        $user->url = Input::get('url');
                        $send = $user->url;
                        break;
                    case 'city':
                        $user->city = Input::get('city');
                        $send = $user->city;
                        break;
                    case 'nif':
                        $user->nif = Input::get('nif');
                        $send = $user->nif;
                        break;
                }
                
                // si consigue guardar, enviara la informacion con el mensaje
                if($user->save()){
                     return array(
                        'save'=>true,
                        'message'=>trans('message.changeInformation.saved'),
                        'data'=>$send,
                    );
                } 
            }
            
            return array(
                'save'=>false,
                'message'=>$message,
            );
            
        }
        
        public function deleteUser(){
            
            User::destroy(Auth::user()->id);
            return Redirect::to('/')->with('message',trans('message.deleteUser.deleted'));
            
        }
        
        
        public function search(){
            
            if(Request::ajax()){
                $brand = Brand::select('name')->where('name','like','%'.Input::get('words').'%')->get();
                
                $phone = Phone::select('name')->where('name','like','%'.Input::get('words').'%')->get();
                
                $names = array();
                
                foreach($brand as $value){
                    $names[] = array('name'=>$value->name);
                }
                
                foreach($phone as $value){
                    $names[] = array('name'=>$value->name);
                }
                
                //$names[] = $brand;
                
                // retorna algo parecido a esto: [{"name":"Marca1"},{"name":"Marca2"},{"name":"Marca3"}]
                return $names;
            
            }
            else{
                $view;
                
                $brand = Brand::where('name','=',Input::get('search'))->first();
               
                $phone = Phone::where('name','=',Input::get('search'))->first();
               

                if(count($brand) != 0){
                   $view = Redirect::to('brand/'.$brand->id)->with('brand',$brand);
                }
                else{
                   $view = Redirect::to('phone/'.$phone->id)->with('phone',$phone);
                }
                
                return $view;
            } 
        }
}