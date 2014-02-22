@extends('index')

@section('content')
<div class='col-xs-11 col-sm-8 col-md-8'>
    <h1>Formulario Login</h1>
    {{ Form::open(array('url' => 'login','role'=> 'form',)) }}
    
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
    </div>
@stop