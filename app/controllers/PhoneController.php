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
                $phone->id_user = Auth::user()->id;
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
            // si esta autentificado, se le hace un descuento al precio 
            // y se le muestra un mensaje
            // en caso contrario, solo se le muestra un mensaje informando de 
            // las ventajas de estar registrado
            if(Auth::check()){
                $message = trans('message.discount.logged',
                        array(
                            'discount'=>$phone->discount,
                            'price'=>$phone->price
                        )
                );
                // obtengo el 80% del precio y lo redondeo a 2 decimales
                // con round()
                $phone->price = round(((100-$phone->discount) * $phone->price)/100,2);
                //$phone->price = round($phone->price/2.65,2);
            }
            else{
                
                $message = trans('message.discount.noLogged',
                        array(
                            'discount'=>$phone->discount,
                            'price'=>$phone->price
                        )
                );
            }
            
            // Guardo el mensaje de descuento en la sesion como session flash
            Session::flash('message',$message);
            
            // Genero la vista y le envio la informacion necesaria
            return View::make('showPhone')
                    ->with('phone',$phone);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
            // obtengo el telefono a editar mediante la id que se envia por get
            $phone = Phone::findOrFail($id);
            // devuelvo la vista para actualizar el telefono
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
            // Compruebo si ha pasado la validacion
            $pass = Validator::make(Request::all(),Phone::$rules);
            // si la validacion no falla entonces guardo la informacion
            if(!$pass->fails()){
                $phone = Phone::findOrFail($id);
                //$phone->name = $phone->name;
                $phone->cpu = Input::get('cpu');
                $phone->ram = Input::get('ram');
                $phone->camera = Input::get('camera');
                $phone->image = Input::get('image');
                $phone->price = Input::get('price');
                $phone->discount = Input::get('discount');
                $phone->description = Input::get('description');
                //Si la informacino se guarda con exito, se redirijira a la vista phone
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
            // Elimina el telefono mediante la id que se le pasa
            Phone::destroy($id);
            // redirige a la vista phone con un mensaje
            return Redirect::to('phone')->with('message','El telefono ha sido borrado');
	}

}