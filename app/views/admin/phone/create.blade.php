@extends('index')

@section('content')
    <h1>Formulario añadir Telefono</h1>
    {{ Form::open(array('url' => 'phone','role'=> 'form', 'data-stop')) }}
    <!-- -->
    <div class="form-group">
       {{ Form::label('name', 'Nombre') }}
       {{ Form::text('name','',array('class'=>'form-control')) }}
       {{ $errors->first('name') }}
    </div>
    
    <div class="form-group">
       {{ Form::label('image', 'Imagen') }}
       {{ Form::text('image','',array('class'=>'form-control')) }}
       {{ $errors->first('image') }}
    </div>
    
    <div class="form-group">
       {{ Form::label('so', 'Sistema operativo') }}
       {{ Form::text('so','',array('class'=>'form-control')) }}
       {{ $errors->first('so') }}
    </div>
    
    <div class="form-group">
       {{ Form::label('cpu', 'Procesador') }}
       {{ Form::text('cpu','',array('class'=>'form-control')) }}
       {{ $errors->first('cpu') }}
    </div>
    
    <div class="form-group">
       {{ Form::label('ram', 'Memoria ram') }}
       {{ Form::text('ram','',array('class'=>'form-control')) }}
       {{ $errors->first('ram') }}
    </div>
    
    <div class="form-group">
       {{ Form::label('camera', 'Camara') }}
       {{ Form::text('camera','',array('class'=>'form-control')) }}
       {{ $errors->first('camera') }}
    </div>
    
       {{ Form::hidden('id_brand',$id,array('class'=>'form-control')) }} 

       {{ Form::submit('añadir',array('class'=>'btn btn-default')) }}
    {{ Form::close() }}
@stop
