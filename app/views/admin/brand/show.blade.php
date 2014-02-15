@extends('index')

@section('content')
    <table class="table">
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>MOVILES</th>
            <th>ACCIONES</th>
            @foreach($brands as $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->phone }}</td>
                    <td>
                        {{ Form::open(array('url' => array('brand',$value->id),'method' => 'DELETE','class' => 'form-inline')) }}
                            {{ Form::submit('Eliminar',array('class'=>'btn btn-danger')) }}
                        {{ Form::close() }}
                        
                        {{ HTML::link('brand/'.$value->id.'/edit','Cambiar datos',array('class'=>'btn btn-primary')) }} 
                        
                        {{ HTML::link('phone/create/'.$value->id,'Añadir telefono',array('class'=>'btn btn-primary')) }}
                    </td>
                </tr>
            @endforeach
        </tr>
    </table>
{{ HTML::link('brand/create','Añadir marca',array('class'=>'btn btn-primary')) }}
@stop
