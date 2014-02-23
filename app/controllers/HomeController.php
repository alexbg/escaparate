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
                    ->paginate(12);
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
            $phones = Phone::OrderAsc()->paginate(6);
            $brands = Brand::all();
            
            // devuelvo las vistas. Esta vista SOLO sera pasada cuando no sea una peticion ajax
            return $view = View::make('showPhones')
                    ->with('phones',$phones)
                    ->with('brands',$brands);
                   
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
                   $view = Redirect::to('showPhonesByBrand/'.$brand->id)->with('brand',$brand);
                }
                else{
                   $view = Redirect::to('phone/'.$phone->id)->with('phone',$phone);
                }
                
                return $view;
            } 
        }
        
        public function showPhonesByBrand($id){
            $phones = Brand::find($id)->phones;
            
            return View::make('showPhonesByBrand')->with('phones',$phones);
        }
}