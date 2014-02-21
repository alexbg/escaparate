<?php

class CommentController extends \BaseController {

    
        /**
         * Para poder realizar cuanquiera de las siguientes acciones, el usuario
         * debera de estar logueado
         */
        public function __construct() {
            
            $this->beforeFilter('auth',array('except'=>'store'));
            $this->beforeFilter('ajaxAuth');
            
        }
    
	/**
	 * Muestra todos los comentarios que el usuario ha creado de forma
         * paginada de 10 en 10
	 *
	 * @return Response
	 */
	public function index()
	{
            $user = User::find(Auth::user()->id);
            return View::make('profile/allComments')->with('user',$user);
	}

	/**
	 * Muestra el formulario para crear un nuevo comentario
	 * La id que recibe como parametro, es la id de telefono en el que va a
         * crear el comentario
	 * @return Response
	 */
	public function create($id)
	{
            return View::make('comments/create')->with('id',$id);
	}

	/**
	 * Almacena el comentario en la base de datos
	 * La id que recibe como parametro, es la id de telefono en el que va a
         * crear el comentario.
	 * @return Response
	 */
	public function store($id)
	{
            // Compruebo que la informacion es correcta, si todo esta bien
            //almaceno la informacion en la base de datos e informo al usuario
            // Validator::make(Request::all(),Comment::$rules); POR SI SOLO SIEMPRE DEVUELVE TRUE
            // PASE O NO PASE LA VALIDACION
            /*$pass = Validator::make(Request::all(),Comment::$rules);
            if(!$pass->fails()){
                $comment = new Comment(Request::all());
                
                $comment->id_phone = $id;
                $comment->id_user = Auth::user()->id;
                
                if($comment->save()){
                     return Redirect::to('phone/'.$id)->with('message','El comentario ha sido añadido');
                }
                
            }
            
            return Redirect::to('comment/create/'.$id)
                            ->with('message','El comentario no puede estar vacio');*/
            // Inicio el mensaje de error
            $message = 'Hay algun error';
            
            // compruebo si el comentario es valido con la validacion
            $pass = Validator::make(Request::all(),Comment::$rules);
            
            if(!$pass->fails()){
                $comment = new Comment(Request::all());
                
                $comment->id_phone = $id;
                $comment->id_user = Auth::user()->id;
                
                if($comment->save()){
                     //return Redirect::to('phone/'.$id)->with('message','El comentario ha sido añadido');
                    return array(
                        'save'=>true,
                        'message'=>'El comentario ha sido guardado',
                        'type'=>'comment',
                        'data'=>array(
                            'user'=>Auth::user()->username,
                            'created'=>$comment->created_at,
                            'comment'=>$comment->comment
                        )
                    );
                }
                else{
                    $message = 'No se puede guardar en el servidor, intentelo mas tarde';
                }
                
            }
            else{
                $message = 'La informacion enviada no es valida';
            }
            
            return array(
                'save'=>false,
                'message'=>$message,
                'data'=>array(
                    'error'=>$pass->messages()->toArray()
                )
            );
            
            
                            
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Muestro el formulario para actualizar el comentario
	 * La id es del comentario a actualizar
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
            /*$comment = Comment::find($id);
            return View::make('comments/update')->with('comment',$comment);*/
            
            $message = 'Hay algun dato erroneo';
            $validar = array('comment'=>Input::get('value'));
            $pass = Validator::make(Request::all(),Comment::$rules);
            if(!$pass->fails()){
                $comment = Comment::find($id);
                $comment->comment = Input::get('comment');
                if($comment->save()){
                    return array(
                        'save'=>true,
                        'message'=>'El comentario ha sido editado',
                        'data'=>$comment->comment,   
                    );
                }
            }
            
            return array(
                'save'=>false,
                'message'=>$message
            );
	}

	/**
	 * actualiza la informacion en la base de datos con los datos enviados por el
         * formulario de los comentarios
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            $pass = Validator::make(Request::all(),Comment::$rules);
            
            if(!$pass->fails()){
                $comment = Comment::findOrFail($id);
                $comment->comment = Input::get('comment');
                if($comment->save()){
                    return Redirect::to('profile')->with('message','El comentario ha sido cambiado');
                }
            }
            
            // INTENTAR CAMBIAR ESTA RUTA PARA HACERLO DE OTRA FORMA
            return Redirect::to('comment/'.$id.'/edit')
                ->withErrors($pass);
	}
        
        public function more(){
            
            $comments = Comment::where('id_user',Auth::user()->id)
                    ->where('id','<',Input::get('id'))
                    ->orderBy('created_at','DESC')
                    ->take(2)->get();
            
            $names = array();
            // Con esto fuerzo a que me carge en $comments todas las relaciones que tienen
            // los comentarios con los telefonos. Ya que al hacer el $value->phone el ya guarda
            // la informacion del telefono en cada comentarios correspondiente en $comments
            foreach($comments as $value){
                $value->phone;
            }

            /*return array(
                'data'=>array(
                    'comments'=>$comments,
                )
            );*/
            
            return $comments;
        }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}