<?php

class BrandController extends \BaseController {

    /**
     * Solamente los usuarios que pasen el filtro de admin, pueden usar los metodos
     * de este controlador
     */
    public function __construct() {
        
        $this->beforeFilter('admin');
        
    }
    
	/**
	 * Muestra las marcas que hay y las acciones que pueden hacer.
	 *
	 * @return Response
	 */
	public function index()
	{
            $brands = Brand::all();
            return View::make('admin/brand/show')->with('brands',$brands);
	}

	/**
	 * Muestra el formulario para crear una nueva marca
	 *
	 * @return Response
	 */
	public function create()
	{
            return View::make('admin/brand/create');
	}

	/**
	 * Comprueba los datos enviados por el fomulario apra crear una marca.
         * Si son correctos, y validos, los almacena en la tabla Brand
	 *
	 * @return Response
	 */
	public function store()
	{
            // almacena enla base de datos los datos enviados por el formulario de
            // crear marca. Valida la peticion y si todo esta bien, lo registra en la base de datos
            // y envia un mensaje al usuario. Si ha saido mal, envia los errores al usuario
            $pass = Validator::make(Request::all(),Brand::$rules);
            
            if(!$pass->fails()){
                $brand = new Brand();
                $brand->name = Input::get('name');
                if($brand->save()){
                    return Redirect::to('brand')
                            ->with('message','La marca ha sido añadida');
                }
            }
            
            return Redirect::to('brand/create')
                            ->with('message','Hay algun error')
                            ->withErrors($pass);
	}

	/**
	 * Por ahora esta de adorno
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Muestra el formulario para editar una marca
	 * recibe un parametro que esl el id de la amrca a actualizar
         * y devuelve un formulario con la informacion de la marca
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
            $brand = Brand::findOrFail($id);
            return View::make('admin/brand/update')->with('brand',$brand);
	}

	/**
	 * Comprueba que lo datos enviados por el formulario de actualizacion de
         * las marcas son correctos y los almacena en la abse de datos
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
             
            $pass = Validator::make(Request::all(),Brand::$rules);
            
            if(!$pass->fails()){
                $brand = Brand::findOrFail($id);
                $brand->name = Input::get('name');
                if($brand->save()){
                    return Redirect::to('brand')->with('message','Los datos han sido cambiados');;
                }
            }
            
            // INTENTAR CAMBIAR ESTA RUTA PARA HACERLO DE OTRA FORMA
            return Redirect::to('brand/'.$id.'/edit')
                ->withErrors($pass);
	}

	/**
	 * Elimina la marca enviadda mediante su id pasado como parametro
         * Hace una eliminacion en cascada tal y como esta configurado en la
         * base de datos. Devuelve un mensaje al usuario
	 * 
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
            // Esta configurado en el migrate de forma que borre los telefonos
            // que estan ligados la marca(brand)
            Brand::destroy($id);
            return Redirect::to('brand')->with('message','La marca ha sido borrada');
	}

}