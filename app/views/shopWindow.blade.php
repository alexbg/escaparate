@section('content')

<div class='col-xs-12 col-sm-12 col-md-12'>
    <h2>{{ trans('titles.theLastPhones') }}</h2>    
</div>

<?php $contador=0; ?>
    @foreach($phones as $value)
        
            <div class='col-sm-4 col-md-3 hidden-xs'>
                <div class="thumbnail altura text-center">
                    <a href=''>
                        {{ HTML::image($value->image ,$value->id,array('data-src'=>$value->image)) }}
                    </a>
                    <div class='caption'>

                        <h3>{{ HTML::link('/phone/'.$value->id,$value->name) }}</h3>
                      <p>{{ $value->description }}</p>

                    </div>
                </div>
            </div>
    
        <div class='col-xs-12 visible-xs'>
            <div class="thumbnail text-center">
                <a href=''>
                    {{ HTML::image($value->image ,$value->id,array('data-src'=>$value->image)) }}
                </a>
                <div class='caption'>

                    <h3>{{ HTML::link('/phone/'.$value->id,$value->name) }}</h3>
                  <p>{{ $value->description }}</p>

                </div>
            </div>
        </div>

    @endforeach
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        {{ $phones->links() }}
    </div>
@stop