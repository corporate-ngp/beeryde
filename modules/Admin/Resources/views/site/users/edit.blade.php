@extends('admin::layouts.master')

@section('template-level-scripts')
@parent
{!! HTML::script( URL::asset('js/admin/users.js') ) !!}
@stop

@section('scripts')
@parent
<script>
    jQuery(document).ready(function () {
        siteObjJs.admin.usersJs.initEdit();
    });
</script>
@stop

@section('content')

{{--*/ $menus = [
    ['label' => 'Site User Management', 'link' => 'javascript:;'],
    ['label' => 'Site User Edit', 'link' => '']];
/*--}}
@include('admin::partials.breadcrumb', ['title' => trans('admin::controller/user.manage-users'), 'menus' => $menus ])
@include('admin::partials.error', ['type' => 'success', 'message' => session('ok'), 'errors' => $errors])

<div class="portlet box yellow-gold">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil"></i>Site User Edit
        </div>
    </div>
    <div class="portlet-body form">
        {!! Form::model($user, ['route' => ['admin.site-user.update', $user->id], 'data-user-id' => $user->id, 'id' => 'admin-user-form', 'method' => 'put', 'class' => 'form-horizontal admin-user-form', 'files' => 'true']) !!}
        @include('admin::site.users.form',['from'=>'update'])
        {!! Form::close() !!}
    </div>
</div>

@stop