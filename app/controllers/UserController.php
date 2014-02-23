<?php

class UserController extends BaseController {

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
            /*$this->beforeFilter('auth',array(
                'except'=>array(
                    'login',
                    'index',
                    'register',
                    'showPhones',
                    'search',
                    'showPhonesByBrand',
                    )
                )
            );*/
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
}
?>
