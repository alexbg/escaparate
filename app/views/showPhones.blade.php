@extends('index')

@section('content')
<div class='col-xs-12 col-sm-3 col-md-3'>
    <div class="list-group">
        <!-- Enlace Todos no usa ajax -->
        {{ HTML::link('/showPhones/','Todos', array('class'=>'list-group-item active')) }}

        @foreach($brands as $value)
                {{ HTML::link('/showPhones/'.$value->id,$value->name, array('class'=>'list-group-item category', 'id'=>$value->id)) }}
        @endforeach
    
    </div>
</div>
<div class='col-xs-12 col-sm-9 col-md-9'>
    <div id="phones">
        @foreach($phones as $value)
            <div class='col-xs-12 col-sm-4 col-md-4'>
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
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            {{ $phones->links() }}
        </div>
    </div>
    
</div>
@stop
