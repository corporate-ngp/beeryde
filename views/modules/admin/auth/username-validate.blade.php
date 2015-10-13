@extends('admin::layouts.auth')

@section('title')
{!!trans('admin::controller/login.page-title')!!}
@stop

@section('scripts')
@parent
{!! HTML::script( URL::asset('js/admin/auth.js') ) !!}
<script>
    $(function () {
        siteObjJs.admin.authJs.init();

        $("#buttonSelector").click(function (){
            $(this).button('loading');
            // Long waiting operation here
             $(this).button('reset');
        });
        
    });
</script>
@stop

@section('content')
<h3 class="form-title">{!!trans('admin::controller/login.signin')!!}</h3>
<div class="form-group">
    <div id="response-error" class="help-block help-block-error"></div>
    <div id="ip_address-error" class="help-block help-block-error"></div>
</div>
<div id="login-form">
    <div class="form-group">
        <div class="input-group">
            {!! Form::text('username', null, ['class'=>'form-control placeholder-no-fix','placeholder'=>trans('admin::controller/login.username-email') ]) !!}
            <span class="input-group-addon">
                <i class="fa fa-user"></i>
            </span>
        </div>
        <span id="username-error" class="help-block help-block-error"></span>
    </div>
<!--    <div class="form-group captcha-form-group">
        {!! Recaptcha::render() !!}
        <div id="g-recaptcha-response-error" class="help-block help-block-error"></div>
    </div>-->
    <div class="form-action">
        {!! Form::button(trans('admin::controller/login.continue'), ['class'=>'btn btn-success uppercase', 'id'=>'login-continue','data-label'=>trans('admin::controller/login.continue')]) !!}
    </div>
</div>
@stop

