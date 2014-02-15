@extends('index')

@section('content')
    <h1>Formulario añadir marca</h1>
    {{ Form::open(array('url' => 'brand','role'=> 'form')) }}
    <!-- -->
    <div class="form-group">
       {{ Form::label('name', 'Nombre') }}
       {{ Form::text('name','',array('class'=>'form-control')) }}
       {{ $errors->first('name') }}
    </div>
    
        {{ Form::submit('añadir',array('class'=>'btn btn-default')) }}
    {{ Form::close() }}
@stop
