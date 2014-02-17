@extends('index')

@section('content')
<!-- TRADUCCIENDO CON trans() -->
<!-- FALTA TERMINAR TRADUCCIR -->


<!-- Muestro informacion sobre el usuario como: email, idioma, etc -->
<div class='col-xs-12 col-sm-6 col-md-6'>
    <h1>Perfil de {{ $user->name }}</h1>
    <h2>Datos:</h2>
    <strong>Correo Electronico: </strong><span id='email'>{{ Auth::user()->email }}</span></br>
    <strong>Idioma: </strong><span id='language'>{{ Config::get('app.locale') }}</span></br>
    
    <strong>Fecha de nacimiento: </strong>
        <span id='date' class='edit-span'>
            {{ Auth::user()->date }}
        </span>
        {{ HTML::link('changeInformation','edit',array('class'=>'edit-button','name'=>'date')) }}</br>
        
    <strong>Telefono: </strong>
    <span id='phone' class='edit-span'>
        {{ Auth::user()->phone_number }}
    </span>
    {{ HTML::link('changeInformation','edit',array('class'=>'edit-button', 'name'=>'phone')) }}</br>
    
    <strong>Direccion: </strong>
        <span id='address' class='edit-span'>
            {{ Auth::user()->address }}
        </span>
    {{ HTML::link('changeInformation','edit',array('class'=>'edit-button', 'name'=>'address')) }}</br>
</div>

<!-- Contiene la parte de las acciones que pueden hacer el usuario -->
<div class='col-xs-12 col-sm-6 col-md-6'>
<!-- Inicio los paneles como acordeon que contienen los formularios -->
    <div class="panel-group" id="accordion">
        <!-- Primer panel, consite en mostrar el formulario para el cambio de
         contraseña, toda la informacion se actualiza con ajax, excepto el eliminar el usuario
        y el cambiar de idioma-->
        <div class="panel">
          <div class="panel-heading">
            <h4 class="panel-title">
                <!-- Titulo del panel que tambien activa el acordeon password -->
              <a data-toggle="collapse" data-parent="#accordion" href="#password">
                {{ trans('forms.password.button') }}
              </a>
            </h4>
          </div>
          <div id="password" class="panel-collapse collapse">
            <div class="panel-body">
               
                <!-- Inicio del formulario, este formulario esta ligado al mio.js, es decir funciona con ajax -->
                <h1>{{ trans('forms.password.title') }}</h1>
                {{ Form::open(array('url' => 'changePassword','role'=> 'form', 'name'=>'password')) }}
                <!-- -->

                <div class="form-group">
                   {{ Form::label('oldPassword', trans('forms.password.oldPassword')) }}
                   {{ Form::password('oldPassword',array('class'=>'form-control')) }}
                   <!-- Todas las class=error se encargan de mostrar los mensajes de los datos erroneos -->
                   <div class='error text-danger' name='oldPassword'></div>
                </div>

                <div class="form-group">
                   {{ Form::label('newPassword', trans('forms.password.newPassword')) }}
                   {{ Form::password('newPassword',array('class'=>'form-control')) }}
                   <div class='error text-danger' name='newPassword'></div>
                </div>

                <div class="form-group">
                   {{ Form::label('repeatPassword', trans('forms.password.repeatPassword')) }}
                   {{ Form::Password('repeatPassword',array('class'=>'form-control')) }}
                   <div class='error text-danger' name='repeatPassword'></div>
                </div>

                    {{ Form::submit(trans('forms.password.button'),array('class'=>'btn btn-default')) }}
                {{ Form::close() }}
            </div>
          </div>
        </div>
        
        
        <div class="panel">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#change-email">
                {{ trans('forms.email.button') }}
              </a>
            </h4>
          </div>
          <div id="change-email" class="panel-collapse collapse">
            <div class="panel-body">
               
                <h1>{{ trans('forms.email.title') }}</h1>
                {{ Form::open(array('url' => 'changeEmail','role'=> 'form')) }}
                <!--  -->

                <div class="form-group">
                   {{ Form::label('email', trans('forms.email.changeEmail')) }}
                   {{ Form::email('email',Auth::user()->email,array('class'=>'form-control')) }}
                   <div class='error text-danger' name='email'></div>
                </div>

                    {{ Form::submit(trans('forms.email.button'),array('class'=>'btn btn-default')) }}
                {{ Form::close() }}
            </div>
          </div>
        </div>
        
        <div class="panel">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#delete">
                {{ trans('forms.delete.title') }}
              </a>
            </h4>
          </div>
          <!-- Cambiar el deleteddd por delete y comrpobar que pasa con el modal que siempre elimina al usuario -->
          <div id="deleteddd" class="panel-collapse collapse">
            <div class="panel-body">
                
                <p class='text-warning'>{{ trans('forms.delete.warning') }}</p>
                {{ HTML::link(
                    'deleteUser',
                    trans('forms.delete.button'),
                    array(
                        'class'=>'btn btn-danger',
                        'data-toggle'=>'modal',
                        'data-target'=>'#myModal',
                        )
                   ) }}
            </div>
          </div>
        </div>
        <!-- Panel para cambiar el lenguaje -->
        <div class="panel">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#change-language">
                {{ trans('forms.language.button') }}
              </a>
            </h4>
          </div>
          <div id="change-language" class="panel-collapse collapse">
            <div class="panel-body">
                
                <h1>{{ trans('forms.language.title') }}</h1>
                {{ Form::open(array('url' => 'changeLanguage','role'=> 'form', 'data-stop')) }}
                <!-- -->

                <div class="form-group">
                   {{ Form::label('language', trans('forms.language.language')) }}
                   {{ Form::select('language',array('en'=>'English','es'=>'Español'),' ',array('class'=>'form-control')) }}
                   <div class='error text-danger' name='language'></div>
                </div>

                    {{ Form::submit(trans('forms.language.button'),array('class'=>'btn btn-default')) }}
                {{ Form::close() }}
            </div>
          </div>
        </div>
        
    </div>
    
</div>

<!-- Inicia el modal que mostrara la advertencia al intentar borrar el usuario  -->
<div id='modal'>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            
            <h4 class="modal-title" id="myModalLabel">{{ trans('forms.delete.modal.title') }}</h4>
          </div>
          <div class="modal-body">
            {{ trans('forms.delete.modal.body') }}
          </div>
          <div class="modal-footer">
            {{ HTML::link('#',trans('forms.delete.button'),array('class'=>'btn btn-danger')) }}
            {{ HTML::link('#','Salir',array('class'=>'btn btn-info')) }}
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Parte donde se muestran los comentarios -->
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
                 <span id='comment' class='edit-span'>
                    {{ $value->comment }}
                </span> 
            </div>
            <div class="panel-footer">
                {{ HTML::link('comment/'.$value->id."/edit",'Editar',array('class'=>'edit-button', 'name'=>'comment')) }}
            </div>
        </div>
    @endforeach
</div>
@stop
