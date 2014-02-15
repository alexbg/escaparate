@extends('index')

@section('content')
    <h1>Formulario Login</h1>
    {{ Form::open(array('url' => 'login','role'=> 'form')) }}
    
        <div class="form-group">
            {{ Form::label('email', 'Correo electronico') }}
            {{ Form::email('email','',array('class'=>'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('password', 'Contraseña') }}
            {{ Form::password('password',array('class'=>'form-control')) }}
            
        </div>
            {{--  an easy method of protecting your application from cross-site request forgeries
                CSRF Protection --}}
            {{ Form::token() }}
            {{ Form::submit('Login',array('class'=>'btn btn-default')) }}

    
    {{ Form::close() }}
@stop