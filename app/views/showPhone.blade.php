@extends('index')

@section('content')

<div class='col-xs-12 col-sm-12 col-md-12'>
    <h2>{{ $phone->name }}</h2>
</div>

<div class='col-xs-4 col-sm-4 col-md-4'>
    {{ HTML::image($phone->image,'imagen Telefono',array('class'=>'img-thumbnail')) }}
</div>
        
<div class='col-xs-4 col-sm-4 col-md-4'>
    <ul class="list-group">
        <li class="list-group-item"><strong>Nombre: </strong>{{ $phone->name }}</li>
        <li class="list-group-item"><strong>SO: </strong>{{ $phone->so }}</li>
        <li class="list-group-item"><strong>CPU: </strong>{{ $phone->cpu }}</li>
        <li class="list-group-item"><strong>RAM: </strong>{{ $phone->ram }}</li>
        <li class="list-group-item"><strong>Camera: </strong>{{ $phone->camera }}</li>
    </ul>
</div>
        
<div class='col-xs-12 col-sm-12 col-md-12'>
    <ul class="nav nav-tabs">
      <li class="active">{{ HTML::link('#description','Descripcion',array('data-toggle'=>'tab')) }}</li>
      <li>{{ HTML::link('#comments','Comentarios',array('data-toggle'=>'tab')) }}</li>
      
    </ul>


    <div class="tab-content">
      <div class="tab-pane active" id="description">Aqui se pondra la descripcion{{ $phone->description }}</div>
      <div class="tab-pane" id="comments">
          {{ HTML::link('comment/create/'.$phone->id,'Añadir comentario') }}
          
          {{-- Con $phone->comment ya estoy obteniendo el comentario --}}
          @foreach($phone->commentDesc as $value)
            {{-- Con $value que ya sno los comentarios pues si quiero los comentarios seria $value->comment
            
            Es decir, de la tabla comment quiero los comment(comentarios) --}}
            <div class="panel panel-primary">
                <div class="panel-heading">
                  <strong>User: </strong>{{ $value->user->name }} 
                  <strong>Date:</strong> {{ $value->user->created_at }}
                </div>
                <div class="panel-body">
                    {{ $value->comment }}
                </div>
            </div>
          @endforeach
      </div>
    </div>
</div>

@stop


