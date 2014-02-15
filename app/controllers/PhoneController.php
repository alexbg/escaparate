<?php

class PhoneController extends \BaseController {

    
    
        public function __construct() {
            
            $this->beforeFilter('admin',array('except'=>'show'));
            
        }
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            $phones = Phone::all();
            return View::make('admin/phone/show')->with('phones',$phones);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
            return View::make('admin/phone/create')->with('id',$id);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
            // COMPROBAR QUE ES MEJOR:
            // USAR EL CAMPO id_brand PONIENDO EL VALOR YO o
            // USAR Inserting Related Models http://laravel.com/docs/eloquent#inserting-related-models
            // Attaching A Related Model
            $pass = Validator::make(Request::all(),Phone::$rules);
            if(!$pass->fails()){
                $phone = new Phone(Request::all());
                if($phone->save())
                    return Redirect::to('brand')->with('message','Telefono añadido');
            }
            // La ruta phone.create.1 es lo mismo que phone/create/1
            // Los puntos son /
            return Redirect::to('phone/create/'.Input::get('id_brand'))->withErrors($pass);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
            $phone = Phone::find($id);
            //$phone->paginate(0);
            //$comments = $phone->comment()->orderBy('created_at')->get();
            return View::make('showPhone')->with('phone',$phone);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
            $phone = Phone::findOrFail($id);
            return View::make('admin/phone/update')->with('phone',$phone);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            $pass = Validator::make(Request::all(),Phone::$rules);
            
            if(!$pass->fails()){
                $phone = Phone::findOrFail($id);
                //$phone->name = $phone->name;
                $phone->cpu = Input::get('cpu');
                $phone->ram = Input::get('ram');
                $phone->camera = Input::get('camera');
                $phone->image = Input::get('image');
                //$phone->idBrand = $phone->idBrand;
                if($phone->save()){
                    return Redirect::to('phone')->with('message','Los datos han sido cambiados');
                }
            }
            
            // INTENTAR CAMBIAR ESTA RUTA PARA HACERLO DE OTRA FORMA
            return Redirect::to('phone/'.$id.'/edit')
                ->withErrors($pass);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
            Phone::destroy($id);
            return Redirect::to('phone')->with('message','El telefono ha sido borrado');
	}

}