@extends('index')

@section('content')
    <table class="table">
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>MARCA</th>
            <th>ACCIONES</th>
            @foreach($phones as $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->brand->name }}</td>
                   
                    <td>
                        {{ Form::open(array('url' => array('phone',$value->id),'method' => 'DELETE','class' => 'form-inline')) }}
                            {{ Form::submit('Eliminar',array('class'=>'btn btn-danger')) }}
                        {{ Form::close() }}
                        
                        {{ HTML::link('phone/'.$value->id.'/edit','Cambiar datos',array('class'=>'btn btn-primary')) }} 
                        
                    </td>
                </tr>
            @endforeach
        </tr>
    </table>

@stop
