@extends('index')

@section('content')
    <h1>Formulario añadir Telefono</h1>
    {{ Form::model($phone,array('url' => array('phone',$phone->id),'role'=> 'form','method' => 'PUT', 'data-stop')) }}
    <!-- -->
    
    
    <div class="form-group">
       {{ Form::label('image', 'Imagen') }}
       {{ Form::text('image',$phone->image,array('class'=>'form-control')) }}
       {{ $errors->first('image') }}
    </div>
    
    <div class="form-group">
       {{ Form::label('so', 'Sistema operativo') }}
       {{ Form::text('so',$phone->so,array('class'=>'form-control')) }}
       {{ $errors->first('so') }}
    </div>
    
    <div class="form-group">
       {{ Form::label('cpu', 'Procesador') }}
       {{ Form::text('cpu',$phone->cpu,array('class'=>'form-control')) }}
       {{ $errors->first('cpu') }}
    </div>
    
    <div class="form-group">
       {{ Form::label('ram', 'Memoria ram') }}
       {{ Form::text('ram',$phone->ram,array('class'=>'form-control')) }}
       {{ $errors->first('ram') }}
    </div>
    
    <div class="form-group">
       {{ Form::label('camera', 'Camara') }}
       {{ Form::text('camera',$phone->camera,array('class'=>'form-control')) }}
       {{ $errors->first('camera') }}
    </div>

    <div class="form-group">
       {{ Form::label('price', 'Precio') }}
       {{ Form::text('price',$phone->price,array('class'=>'form-control')) }}
       {{ $errors->first('price') }}
    </div>
    
    <div class="form-group">
       {{ Form::label('discount', 'Descuento') }}
       {{ Form::text('discount',$phone->discount,array('class'=>'form-control')) }}
       {{ $errors->first('discount') }}
    </div>
    
    <div class="form-group">
       {{ Form::label('description', 'Descripcion') }}
       {{ Form::textArea('description',$phone->description,array('class'=>'form-control')) }}
       {{ $errors->first('description') }}
    </div>
    
       {{ Form::submit('Actualizar',array('class'=>'btn btn-default')) }}
    {{ Form::close() }}
@stop
