@extends('index')

@section('content')
    <h1>Formulario Actualizar Comentario</h1>
    {{ Form::model($comment,array('url' => array('comment','id'=>$comment->id),'role'=> 'form','method'=>'PUT')) }}
    <!-- -->
    <div class="form-group">
       {{ Form::label('comment', 'Comentario') }}
       {{ Form::textArea('comment',$comment->comment,array('class'=>'form-control')) }}
       {{ $errors->first('comment') }}
    </div>
    
        {{ Form::submit('Actualizar',array('class'=>'btn btn-default')) }}
    {{ Form::close() }}
@stop