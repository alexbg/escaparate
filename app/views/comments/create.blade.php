@extends('index')

@section('content')
    <h1>Formulario añadir Comentario</h1>
    {{ Form::open(array('url' => array('comment/store','id'=>$id),'role'=> 'form')) }}
    <!-- -->
    <div class="form-group">
       {{ Form::label('comment', 'Comentario') }}
       {{ Form::textArea('comment','',array('class'=>'form-control')) }}
       {{ $errors->first('comment') }}
    </div>
    
        {{ Form::submit('Enviar',array('class'=>'btn btn-default')) }}
    {{ Form::close() }}
@stop
