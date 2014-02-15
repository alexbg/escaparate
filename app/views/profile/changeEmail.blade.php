@extends('index')

@section('content')

<h1>Formulario Cambiar email</h1>
    {{ Form::open(array('url' => 'changeEmail','role'=> 'form')) }}
    <!-- -->

    <div class="form-group">
       {{ Form::label('email', 'Nuevo email') }}
       {{ Form::email('email','',array('class'=>'form-control')) }}
       {{ $errors->first('email') }}
    </div>
    
        {{ Form::submit('Cambiar Email',array('class'=>'btn btn-default')) }}
    {{ Form::close() }}

@stop