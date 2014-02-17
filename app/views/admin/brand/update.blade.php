@extends('index')

@section('content')
    <h1>Formulario añadir marca</h1>
    {{ Form::model($brand, array('url' => array('brand',$brand->id),'method' => 'PUT', 'data-stop')) }}
    <!-- -->
    <div class="form-group">
       {{ Form::label('name', 'Nombre') }}
       {{ Form::text('name',$brand->name,array('class'=>'form-control')) }}
       {{ $errors->first('name') }}
    </div>
    
        {{ Form::submit('añadir',array('class'=>'btn btn-default')) }}
    {{ Form::close() }}
@stop
