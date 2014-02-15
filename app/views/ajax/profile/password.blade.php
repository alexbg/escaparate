<h1>Formulario cambiar contraseña</h1>
    {{ Form::open(array('url' => 'changePassword','role'=> 'form')) }}
    <!-- -->

    <div class="form-group">
       {{ Form::label('oldPassword', 'Su contraseña actual') }}
       {{ Form::password('oldPassword',array('class'=>'form-control')) }}
       {{ $errors->first('oldPassword') }}
    </div>
    
    <div class="form-group">
       {{ Form::label('newPassword', 'Su nueva contraseña') }}
       {{ Form::password('newPassword',array('class'=>'form-control')) }}
       {{ $errors->first('newPassword') }}
    </div>
    
    <div class="form-group">
       {{ Form::label('repeatPassword', 'Repita la contraseña') }}
       {{ Form::Password('repeatPassword',array('class'=>'form-control')) }}
       {{ $errors->first('repeatPassword') }}
    </div>
    
        {{ Form::submit('Cambiar Contraseña',array('class'=>'btn btn-default')) }}
    {{ Form::close() }}
