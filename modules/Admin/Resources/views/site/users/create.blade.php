@extends('admin::layouts.master')


@section('template-level-scripts')
@parent
{!! HTML::script( URL::asset('js/admin/site/users.js') ) !!}
@stop

@section('scripts')
@parent
<script>
    jQuery(document).ready(function () {
        siteObjJs.admin.siteUsersJs.initCreate();
    });
</script>
@stop

@section('content')

{{--*/ $menus = [
    ['label' => trans('admin::controller/user.user-management'), 'link' => 'admin/site/site-user'],
    ['label' => trans('admin::controller/user.create-user')]];
/*--}}
@include('admin::partials.breadcrumb', ['title' => trans('admin::controller/user.manage-users'), 'menus' => $menus ])
@include('admin::partials.error', ['type' => 'success', 'message' => session('ok'), 'errors' => $errors])

<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa icon-plus"></i>{!! trans('admin::messages.add-name', ['name' =>trans('admin::controller/user.user')]) !!}
        </div>
    </div>
    <div class="portlet-body form">      
        {!! Form::open(['route' => ['admin.site-user.store'], 'data-user-id' => '', 'id' => 'admin-user-form', 'method' => 'post', 'class' => 'form-horizontal admin-user-form', 'files' => 'true']) !!}
        @include('admin::site.users.form',['from'=>'create'])
        {!! Form::close() !!}
    </div>
</div>

@stop