@foreach($phones as $value)
    <div class='col-sm-6 col-md-4 hidden-xs'>
                <div class="thumbnail altura text-center">
                    <div class='caption'>
                        <h3>{{ HTML::link('/phone/'.$value->id,$value->name) }}</h3>
                    </div>
                    <a href=''>
                    {{ HTML::image($value->image ,$value->id,array('data-src'=>$value->image)) }}
                    </a>
                    <div class="caption">

                      <p>{{ $value->description }}</p>

                    </div>
                </div>
            </div>
        
            <div class='col-xs-12 visible-xs'>
                <div class="thumbnail text-center">
                    <div class='caption'>
                        <h3>{{ HTML::link('/phone/'.$value->id,$value->name) }}</h3>
                    </div>
                    <a href=''>
                    {{ HTML::image($value->image ,$value->id,array('data-src'=>$value->image)) }}
                    </a>
                    <div class="caption">

                      <p>{{ $value->description }}</p>

                    </div>
                </div>
            </div>
@endforeach
