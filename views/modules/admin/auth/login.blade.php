{!! Form::open(['url' => ['admin/auth/login'], 'method' => 'post', 'id'=>'loginForm']) !!}
<div id="login-error-msg"></div>
<div class="form-group">
    <label class="control-label visible-ie8 visible-ie9">{!! trans('admin::controller/login.username') !!}</label>
    <div class="input-group">
        {!! Form::text('username', null, ['class'=>'form-control placeholder-no-fix','placeholder'=>trans('admin::controller/login.username-email'),'disabled' ]) !!}
        <span class="input-group-addon">
            <i class="fa fa-user"></i>
        </span>
    </div>
</div>
<div class="form-group">
    <div class="input-group">
        {!! Form::password('password', ['class'=>'form-control placeholder-no-fix','placeholder'=>trans('admin::controller/login.password'),'id'=>'password']) !!}
        <span class="input-group-addon">
            <i class="fa fa-lock"></i>
        </span>
    </div>
</div>
<div class="form-action">
    {!! Form::submit(trans('admin::controller/login.login'), array('class' => 'btn btn-success uppercase')) !!}
</div>
{!! Form::close() !!}