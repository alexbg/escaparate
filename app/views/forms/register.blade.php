@extends('index')

@section('content')
    <h1>Formulario registro</h1>
    {{ Form::open(array('url' => 'register','role'=> 'form')) }}
    <!-- -->
    <div class="form-group">
       {{ Form::label('username', 'Nombre de usuario') }}
       {{ Form::text('username','',array('class'=>'form-control')) }}
       <div class='error' name='username'></div>
    </div>
     
    <div class="form-group">
        {{ Form::label('password', 'Contraseña') }}
        {{ Form::password('password',array('class'=>'form-control')) }}
        <div class='error' name='password'></div>
    </div>  
    
    <div class="form-group">
        {{ Form::label('email', 'Correo electronico') }}
        {{ Form::email('email','',array('class'=>'form-control')) }}
        <div class='error' name='email'></div>
    </div>
    
    <div class="form-group">
        {{ Form::label('address', 'Direccion') }}
        {{ Form::text('address','',array('class'=>'form-control')) }}
        <div class='error' name='address'></div>
    </div>
    
    <div class="form-group">
        {{ Form::label('phone', 'Numero de telefono') }}
        {{ Form::text('phone','',array('class'=>'form-control')) }}
        <div class='error' name='phone'></div>
    </div>
    
    <div class="form-group">
        {{ Form::label('date', 'Fecha de nacimiento') }}
        <div class="col-xs-12">
            <div class="col-xs-12 col-sm-4">
                {{ Form::label('day', 'Dia') }}
                {{ Form::text('day','',array('class'=>'form-control')) }}
                <div class='error' name='day'></div>
            </div>
            
            <div class="col-xs-12 col-sm-4">
                   {{ Form::label('month', 'Mes') }}
                   {{ Form::text('month','',array('class'=>'form-control')) }}
                   <div class='error' name='month'></div>
            </div>
            
            <div class="col-xs-12 col-sm-4">
                   {{ Form::label('year', 'Año') }}
                   {{ Form::text('year','',array('class'=>'form-control')) }}
                   <div class='error' name='year'></div>
            </div>
           
        </div>
        
    </div>
    
    <div class="form-group">

        {{ Form::submit('registrate',array('class'=>'btn btn-default')) }}
 
    </div>
    {{ Form::close() }}
@stop
