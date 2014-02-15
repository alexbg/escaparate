@extends('index')

@section('content')
    <h1>Formulario registro</h1>
    {{ Form::open(array('url' => 'register','role'=> 'form')) }}
    <!-- -->
    <div class="form-group">
       {{ Form::label('username', 'Nombre de usuario') }}
       {{ Form::text('username','',array('class'=>'form-control', 'id'=>'register')) }}
       {{ $errors->first('username') }}
    </div>
     
    <div class="form-group">
        {{ Form::label('password', 'Contraseña') }}
        {{ Form::password('password',array('class'=>'form-control')) }}
        {{ $errors->first('password') }}
    </div>  
    
    <div class="form-group">
        {{ Form::label('email', 'Correo electronico') }}
        {{ Form::email('email','',array('class'=>'form-control')) }}
        {{ $errors->first('email') }}
    </div>  
        {{ Form::submit('registrate',array('class'=>'btn btn-default')) }}
    {{ Form::close() }}
@stop
