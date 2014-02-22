@extends('index')

@section('content')

<div class='col-xs-12 col-sm-12 col-md-12'>
    <h2>{{ $phone->name }}</h2>
</div>

<div class='col-xs-12 col-sm-4'>
    {{ HTML::image($phone->image,'imagen Telefono',array('class'=>'img-thumbnail')) }}
</div>
        
<div class='col-xs-12 col-sm-8'>
    <!-- si hay un usuario registrado, el precio sera un 20 porciendo mas barato-->
    <h1>{{ trans('global.price')}}: {{ $phone->price }} EUR</h1>

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
      <li class="active">{{ HTML::link('#description',trans('buttons.description'),array('data-toggle'=>'tab')) }}</li>
      <li>{{ HTML::link('#comments',trans('buttons.comments'),array('data-toggle'=>'tab')) }}</li>
      
      
    </ul>


    <div class="tab-content">
      <div class="tab-pane active" id="description">
          <h2>{{ trans('buttons.description') }}</h2>
          {{ $phone->description }}
      </div>
        
      <div class="tab-pane" id="comments">
          <!--{{ HTML::link('comment/create/'.$phone->id,'Añadir comentario') }}-->
          
          <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                        {{ HTML::link('#comment',trans('forms.comment.addComment'),array('data-parent'=>'#accordion', 'data-toggle'=>'collapse')) }}
                    </h4>
                  </div>
                  <div id="comment" class="panel-collapse collapse">
                    <div class="panel-body">
                        <h1>{{ trans('forms.comment.title') }}</h1>
                        {{ Form::open(array('url' => array('comment/store','id'=>$phone->id),'role'=> 'form')) }}
                        <!-- -->
                        <div class="form-group">
                           {{ Form::label('comment', trans('forms.comment.comment')) }}
                           {{ Form::textArea('comment','',array('class'=>'form-control', 'rows'=>'3')) }}
                           <div class='error text-danger' name='comment'></div>
                        </div>
                        <!-- CAMBIAR ESTO, HE DE PONERLO DIRECTAMENTE EN LA INFORMACION QUE SE ENVIA-->
                           <!-- {{ Form::text('id',$phone->id,array('class'=>'form-control hidden', 'disabled')) }}-->
                        <!-- CAMBIAR LO DE EL ENVIO DEL ID -->
                            {{ Form::submit(trans('forms.comment.button'),array('class'=>'btn btn-default')) }}
                        {{ Form::close() }}
                    </div>
                  </div>
                </div>
            </div>
          
          
          <h2>{{ trans('titles.theLastComments') }}</h2>
          <div class='col-xs-12 col-sm-12 col-md-12' id='add-comment'>
            {{-- Con $phone->comment ya estoy obteniendo el comentario --}}
            @foreach($phone->commentDesc as $value)
              {{-- Con $value que ya sno los comentarios pues si quiero los comentarios seria $value->comment

              Es decir, de la tabla comment quiero los comment(comentarios) --}}
              <div class="panel panel-primary">
                  <div class="panel-heading">
                    <strong>User: </strong>{{ $value->user->username }} 
                    <strong>Date:</strong> {{ $value->created_at }}
                  </div>
                  <div class="panel-body">
                      {{ $value->comment }}
                  </div>
              </div>
          @endforeach
          </div>
      </div>
    </div>
</div>

@stop


