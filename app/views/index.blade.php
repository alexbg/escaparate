<html>
    <head>
        <title>Escaparate</title>
        <!-- Cargo los scripts de jquery y boostrap -->
        {{ HTML::script('http://code.jquery.com/jquery-1.10.2.min.js') }}
        {{ HTML::style('assets/css/bootstrap.min.css', array('media' => 'screen')) }}
        {{ HTML::script('assets/js/bootstrap.min.js') }}
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body { padding-top: 70px; }
        </style>  
    </head>
   
    <body>
        <!-- Inicio la creaccion del menu con las clases bo boostrap -->
        <div class ='menu navbar navbar-default navbar-fixed-top navbar-inverse' role='navigation'>
            <div class='container'>
                <!-- Link que ira a la pagina principal -->
                <div class="navbar-header">
                    {{ HTML::link('/','Escaparate',array('class'=>'navbar-brand')) }}
                </div>

                <div class="collapse navbar-collapse">
                    <div class='hidden-xs'>
                        <ul class='nav navbar-nav'>
                            <!-- Compruebo si el usuario esta logueado. Si esta logueado
                            se muestra un menu diferente a cuando no lo esta-->
                            @if(!Auth::check())
                            <!-- Menu no logueado -->
                            <li>{{ HTML::link('login','Login') }}</li>
                            <li>{{ HTML::link('register','Registrate') }}</li>
                            <li>{{ HTML::link('showPhones','Moviles') }}</li>
                            @else
                            <!-- Menu logueado -->
                            <li>{{ HTML::link('profile','Perfil') }}</li>
                                {{-- BUSCAR OTRA FORMA DE COMPROBAR SER ADMIN --}}
                                {{-- ROUTE::FILER NO VALE --}}
                                <!-- Cuando el usuaro es un usuario administrador se muestran dos opciones mas -->
                                @if(Auth::user()->email=='admin@gmail.com')
                                    <li>{{ HTML::link('brand','Crear Marcas') }}</li>
                                    <li>{{ HTML::link('phone','Ver Moviles') }}</li> 
                                @endif
                            <li>{{ HTML::link('showPhones','Moviles') }}</li>
                            @endif
                            
                            
                        </ul>
                        <!-- Inicio formulario de buscada de productos -->
                        {{ Form::open(array('url' => '','role'=> 'search','class'=>'navbar-form navbar-left')) }}

                            <div class="form-group">
                                {{ Form::text('search','',array('class'=>'form-control','placeholder'=>'Buscar')) }}
                            </div>

                        {{ Form::submit('buscar',array('class'=>'btn btn-default')) }}

                        {{ Form::close() }}
                        <!-- se mostrara el link de logout cuando el usuario esta logueado -->
                        @if(Auth::check())
                            <ul class='nav navbar-nav navbar-right'>
                                <li>{{ HTML::link('logout','logout '.'('.Auth::user()->name.')') }}</li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Con session::get manejo los mensajes que se envian para informar al usuario -->
        <div class="container">
            @if(Session::get('message'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ Session::get('message') }}
                </div>

            @endif
        <!-- Este es el mensaje que modifico con javascript -->  
             <div class="alert alert-success">
                    <!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>-->
                  <div id='message'>{{ Session::get('message') }}</div>
             </div>
        <!-- Esta es la parte dinamica de la web -->
            <div class='row'>
                <div class='col-xs-12 col-sm-12 col-md-12'>
                    
                    <!--@if(isset($table))
                        {{ $table }}
                    @endif
                    
                    @yield('phones')-->
                    
                    @yield('content')
                    
                </div>
            </div>
            <!-- Aqui se mostrara la publicidad -->
            <div class='row'>
                <div class='col-xs-12 col-sm-12 col-md-12'>
                    <div class='col-xs-4 col-sm-4 col-md-4'>
                        Informacion
                    </div>
                    <div class='col-xs-4 col-sm-4 col-md-4'>
                        Informacion
                    </div>
                    <div class='col-xs-4 col-sm-4 col-md-4'>
                        Informacion
                    </div>
                </div>
            </div>  
        </div>
        {{ HTML::script('assets/js/mio.js') }}
    </body>
</html>
