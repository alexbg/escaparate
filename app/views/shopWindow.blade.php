@section('content')

<div class='col-xs-12 col-sm-12 col-md-12'>
    <h2>Los ultimos moviles</h2>    
</div>

<?php $contador=0; ?>
    @foreach($phones as $value)
        @if($contador == 4)
            </div>
            <?php $contador=0; ?>
        @endif
        @if($contador ==0)
            <div class='row text-center'>
            <div class='col-xs-12 col-sm-3 col-md-3'>

                    <div class="thumbnail">
                        <a href=''>
                            {{ HTML::image($value->image ,$value->id,array('data-src'=>$value->image)) }}
                        </a>
                        <div class='caption'>

                            <h3>{{ HTML::link('/phone/'.$value->id,$value->name) }}</h3>
                          <p>Descripcion</p>

                        </div>
                    </div>

            </div>
            <?php $contador++; ?>
        @else
            <div class='col-xs-12 col-sm-3 col-md-3'>

                    <div class="thumbnail">
                        <a href=''>
                            {{ HTML::image($value->image ,$value->id,array('data-src'=>$value->image)) }}
                        </a>
                        <div class='caption'>

                            <h3>{{ HTML::link('/phone/'.$value->id,$value->name) }}</h3>
                          <p>Descripcion</p>

                        </div>
                    </div>

            </div>
            <?php $contador++; ?>
        @endif
        
        
   
    @endforeach
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        {{ $phones->links() }}
    </div>
@stop