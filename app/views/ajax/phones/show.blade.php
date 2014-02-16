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
