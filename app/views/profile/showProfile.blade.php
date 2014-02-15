@extends('index')

@section('content')
<div class='col-xs-6 col-sm-6 col-md-6'>
    <h1>Perfil de {{ $user->name }}</h1>
    <h2>Datos:</h2>
    <strong>Correo Electronico: </strong><span id='email'>{{ Auth::user()->email }}</span></br>
    <strong>Idioma: </strong><span id='language'>{{ Config::get('app.locale') }}</span>

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
                {{ trans('forms.password.button') }}
              </a>
            </h4>
          </div>
          <div id="password" class="panel-collapse collapse">
            <div class="panel-body">
                <div class='ajax-gif'>{{ HTML::image('assets/img/ajax-loader.gif','Cargando') }}</div>
                <h1>{{ trans('forms.password.title') }}</h1>
                {{ Form::open(array('url' => 'changePassword','role'=> 'form', 'name'=>'password')) }}
                <!-- -->

                <div class="form-group">
                   {{ Form::label('oldPassword', trans('forms.password.oldPassword')) }}
                   {{ Form::password('oldPassword',array('class'=>'form-control')) }}
                   {{ $errors->first('oldPassword') }}
                   <div class='error' name='oldPassword'></div>
                </div>

                <div class="form-group">
                   {{ Form::label('newPassword', trans('forms.password.newPassword')) }}
                   {{ Form::password('newPassword',array('class'=>'form-control')) }}
                   {{ $errors->first('newPassword') }}
                   <div class='error' name='newPassword'></div>
                </div>

                <div class="form-group">
                   {{ Form::label('repeatPassword', trans('forms.password.repeatPassword')) }}
                   {{ Form::Password('repeatPassword',array('class'=>'form-control')) }}
                   {{ $errors->first('repeatPassword') }}
                   <div class='error' name='repeatPassword'></div>
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
                <div class='ajax-gif'>{{ HTML::image('assets/img/ajax-loader.gif','Cargando') }}</div>
                <h1>{{ trans('forms.email.title') }}</h1>
                {{ Form::open(array('url' => 'changeEmail','role'=> 'form')) }}
                <!-- -->

                <div class="form-group">
                   {{ Form::label('email', trans('forms.email.changeEmail')) }}
                   {{ Form::email('email',Auth::user()->email,array('class'=>'form-control')) }}
                   {{ $errors->first('email') }}
                   <div class='error' name='email'></div>
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
          <div id="delete" class="panel-collapse collapse">
            <div class="panel-body">
                <div class='ajax-gif'>{{ HTML::image('assets/img/ajax-loader.gif','Cargando') }}</div>
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
                <div class='ajax-gif'>{{ HTML::image('assets/img/ajax-loader.gif','Cargando') }}</div>
                <h1>{{ trans('forms.language.title') }}</h1>
                {{ Form::open(array('url' => 'changeLanguage','role'=> 'form')) }}
                <!-- -->

                <div class="form-group">
                   {{ Form::label('language', trans('forms.language.language')) }}
                   {{ Form::select('language',array('en'=>'English','es'=>'Español'),' ',array('class'=>'form-control')) }}
                   <div class='error' name='language'></div>
                </div>

                    {{ Form::submit(trans('forms.language.button'),array('class'=>'btn btn-default')) }}
                {{ Form::close() }}
            </div>
          </div>
        </div>
        
    </div>
    
</div>

<div id='modal'>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">{{ trans('forms.delete.modal.title') }}</h4>
          </div>
          <div class="modal-body">
            {{ trans('forms.delete.modal.body') }}
          </div>
          <div class="modal-footer">
            {{ HTML::link('#',trans('forms.delete.button'),array('class'=>'btn btn-danger')) }}
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
