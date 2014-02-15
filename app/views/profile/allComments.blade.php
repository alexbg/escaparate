@extends('index')

@section('content')
<h2>Todos los comentarios del usuario: {{ $user->name }}</h2>
@foreach($user->comment as $value)

    <div class="panel panel-success">
        <div class="panel-heading">
          {{ HTML::link('phone/'.$value->phone->id,$value->phone->name) }}
          {{ $value->created_at }}
        </div>
        <div class="panel-body">
            {{ $value->comment }}
        </div>
        <div class="panel-footer">
            {{ HTML::link('comment/'.$value->id."/edit",'Editar') }}
        </div>
    </div>

@endforeach

@stop
