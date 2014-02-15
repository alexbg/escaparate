@extends('index')

@section('content')
<div class='col-xs-2 col-sm-2 col-md-2'>
    <div class="list-group">
        {{ HTML::link('/showPhones/','Todos', array('class'=>'list-group-item active category')) }}

        @foreach($brands as $value)
                {{ HTML::link('/showPhones/'.$value->id,$value->name, array('class'=>'list-group-item category', 'id'=>$value->id)) }}
        @endforeach
    
    </div>
</div>
<div class='col-xs-10 col-sm-10 col-md-10'>
    <div class='ajax-gif'>{{ HTML::image('assets/img/ajax-loader.gif','Cargando') }}</div>
    <div id="phones">
        @foreach($phones as $value)
            <div class='col-xs-3 col-sm-3 col-md-3'>
                <div class="thumbnail">
                    <div class='caption'>
                        <h3>{{ HTML::link('/phone/'.$value->id,$value->name) }}</h3>
                    </div>
                    <a href=''>
                    {{ HTML::image($value->image ,$value->id,array('data-src'=>$value->image)) }}
                    </a>
                    <div class="caption">

                      <p>Descripcion</p>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@stop
