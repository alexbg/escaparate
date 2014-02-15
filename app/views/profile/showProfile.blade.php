@extends('index')

@section('content')
<div class='col-xs-6 col-sm-6 col-md-6'>
    <h1>Perfil de {{ $user->name }}</h1>
    <h2>Datos:</h2>
    <strong>Correo Electronico: </strong><span id='email'>{{ Auth::user()->email }}</span>

</div>

<div class='col-xs-6 col-sm-6 col-md-6'>
    
    <!--<ul class="nav nav-pills nav-stacked">
      <li>{{ HTML::link('changePassword','Cambiar contraseña') }}</li>
      <li>{{ HTML::link('comment','Todos los comentarios') }}</li>
      <li>{{ HTML::link('changeEmail','Cambiar correo electronico') }}</li>
      <li>{{ HTML::link('deleteUser','Darse de baja') }}</li>
    </ul>-->

    
    <div class="panel-group" id="accordion">
        <div class="panel">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#password">
                Cambiar contraseña
              </a>
            </h4>
          </div>
          <div id="password" class="panel-collapse collapse">
            <div class="panel-body">
                <div class='ajax-gif'>{{ HTML::image('assets/img/ajax-loader.gif','Cargando') }}</div>
                <h1>Formulario cambiar contraseña</h1>
                {{ Form::open(array('url' => 'changePassword','role'=> 'form', 'name'=>'password')) }}
                <!-- -->

                <div class="form-group">
                   {{ Form::label('oldPassword', 'Su contraseña actual') }}
                   {{ Form::password('oldPassword',array('class'=>'form-control')) }}
                   {{ $errors->first('oldPassword') }}
                   <div class='error' name='oldPassword'></div>
                </div>

                <div class="form-group">
                   {{ Form::label('newPassword', 'Su nueva contraseña') }}
                   {{ Form::password('newPassword',array('class'=>'form-control')) }}
                   {{ $errors->first('newPassword') }}
                   <div class='error' name='newPassword'></div>
                </div>

                <div class="form-group">
                   {{ Form::label('repeatPassword', 'Repita la contraseña') }}
                   {{ Form::Password('repeatPassword',array('class'=>'form-control')) }}
                   {{ $errors->first('repeatPassword') }}
                   <div class='error' name='repeatPassword'></div>
                </div>

                    {{ Form::submit('Cambiar Contraseña',array('class'=>'btn btn-default')) }}
                {{ Form::close() }}
            </div>
          </div>
        </div>
        
        
        <div class="panel">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#change-email">
                Cambiar Correo Electronico
              </a>
            </h4>
          </div>
          <div id="change-email" class="panel-collapse collapse">
            <div class="panel-body">
                <div class='ajax-gif'>{{ HTML::image('assets/img/ajax-loader.gif','Cargando') }}</div>
                <h1>Formulario Cambiar email</h1>
                {{ Form::open(array('url' => 'changeEmail','role'=> 'form')) }}
                <!-- -->

                <div class="form-group">
                   {{ Form::label('email', 'Nuevo email') }}
                   {{ Form::email('email',Auth::user()->email,array('class'=>'form-control')) }}
                   {{ $errors->first('email') }}
                   <div class='error' name='email'></div>
                </div>

                    {{ Form::submit('Cambiar Email',array('class'=>'btn btn-default')) }}
                {{ Form::close() }}
            </div>
          </div>
        </div>
        
        <div class="panel">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#delete">
                Darse de baja
              </a>
            </h4>
          </div>
          <div id="delete" class="panel-collapse collapse">
            <div class="panel-body">
                <div class='ajax-gif'>{{ HTML::image('assets/img/ajax-loader.gif','Cargando') }}</div>
                {{ HTML::link('deleteUser','Darse de baja') }}
            </div>
          </div>
        </div>
        
        <div class="panel">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#language">
                Cambiar idioma
              </a>
            </h4>
          </div>
          <div id="language" class="panel-collapse collapse">
            <div class="panel-body">
                <div class='ajax-gif'>{{ HTML::image('assets/img/ajax-loader.gif','Cargando') }}</div>
                {{ HTML::link('deleteUser','Darse de baja') }}
            </div>
          </div>
        </div>
        
    </div>
    
</div>



<div class='col-xs-12 col-sm-12 col-md-12'>
    <h2>Ultimos 10 comentarios:</h2>

    @foreach($comments as $value)
        {{-- Con $value que ya sno los comentarios pues si quiero los comentarios seria $value->comment

        Es decir, de la tabla comment quiero los comment(comentarios) --}}
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
</div>
@stop
