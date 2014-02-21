@extends('index')

@section('content')
    <h1>Formulario registro</h1>
    {{ Form::open(array('url' => 'register','role'=> 'form')) }}
    <!-- -->
    <div class="form-group">
       {{ Form::label('username', 'Nombre de usuario') }}
       {{ Form::text('username','',array('class'=>'form-control')) }}
       <div class='error text-danger' name='username'></div>
    </div>
     
    <div class="form-group">
        {{ Form::label('password', 'Contraseña') }}
        {{ Form::password('password',array('class'=>'form-control')) }}
        <div class='error text-danger' name='password'></div>
    </div>  
    
    <div class="form-group">
        {{ Form::label('email', 'Correo electronico') }}
        {{ Form::email('email','',array('class'=>'form-control')) }}
        <div class='error text-danger' name='email'></div>
    </div>
    
    <div class="form-group">
        {{ Form::label('address', 'Direccion') }}
        {{ Form::text('address','',array('class'=>'form-control')) }}
        <div class='error text-danger' name='address'></div>
    </div>
    
    <div class="form-group">
        {{ Form::label('phone', 'Numero de telefono') }}
        {{ Form::text('phone','',array('class'=>'form-control')) }}
        <div class='error text-danger' name='phone'></div>
    </div>
    
    <div class="form-group">
        {{ Form::label('date', 'Fecha de nacimiento') }}
        <div class="col-xs-12">
            <div class="col-xs-12 col-sm-4">
                {{ Form::label('day', 'Dia') }}
                {{ Form::text('day','',array('class'=>'form-control')) }}
                <div class='error text-danger' name='day'></div>
            </div>
            
            <div class="col-xs-12 col-sm-4">
                   {{ Form::label('month', 'Mes') }}
                   {{ Form::text('month','',array('class'=>'form-control')) }}
                   <div class='error text-danger' name='month'></div>
            </div>
            
            <div class="col-xs-12 col-sm-4">
                   {{ Form::label('year', 'Año') }}
                   {{ Form::text('year','',array('class'=>'form-control')) }}
                   <div class='error text-danger' name='year'></div>
            </div>
        </div>
        
        <div class='error text-danger' name='date'></div>
 
    </div>
    
    <!-- MOFICADO EN CLASE -->
    
    <div class="form-group">
        {{ Form::label('url', 'url de su pagina web') }}
        {{ Form::text('url','',array('class'=>'form-control')) }}
        <div class='error text-danger' name='url'></div>
    </div>
    
    <div class="form-group">
        {{ Form::label('nif', 'Su numero de identidad') }}
        {{ Form::text('nif','',array('class'=>'form-control')) }}
        <div class='error text-danger' name='nif'></div>
    </div>
    
    <div class="form-group">
        {{ Form::label('sex', 'Su sexo') }}
        {{ Form::select('sex',array(0=>'Mujer',1=>'Hombre'),' ',array('class'=>'form-control')) }}
        <div class='error text-danger' name='sex'></div>
    </div>
    
    <div class="form-group">
        {{ Form::label('city', 'Su ciudad') }}
        {{ Form::text('city','',array('class'=>'form-control')) }}
        <div class='error text-danger' name='city'></div>
    </div>
    
    <div class="form-group">
        {{ Form::label('country', 'Su pais') }}
        {{ Form::text('country','',array('class'=>'form-control')) }}
        <div class='error text-danger' name='country'></div>
    </div>
    
    <div class="form-group">
        {{ Form::label('language', 'Idioma') }}
        {{ Form::select('language',array('en'=>'English','es'=>'Español'),' ',array('class'=>'form-control')) }}
        <div class='error text-danger' name='language'></div>
    </div>
    
    <div class="form-group">
       {{ Form::label('others', 'Observaciones') }}
       {{ Form::textArea('others','',array('class'=>'form-control')) }}
       <div class='error text-danger' name='others'></div>
    </div>
    
    
    
    <div class="form-group">

        {{ Form::submit('registrate',array('class'=>'btn btn-default')) }}
 
    </div>
    {{ Form::close() }}
@stop
