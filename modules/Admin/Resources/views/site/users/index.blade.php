@extends('admin::layouts.master')

@section('template-level-scripts')
@parent
{!! HTML::script( URL::asset('js/admin/site/users.js') ) !!}
@stop

@section('scripts')
@parent
<script>
    jQuery(document).ready(function () {
        siteObjJs.admin.siteUsersJs.init();
        siteObjJs.admin.siteUsersJs.deleteMessage = "{!! trans('admin::messages.delete-message') !!}";
        siteObjJs.admin.siteUsersJs.restoreMessage = "{!! trans('admin::messages.restore-message') !!}";
        siteObjJs.admin.commonJs.boxExpandBtnClick();
    });
</script>
@stop

@section('content')

{{--*/ $menus = [
    ['label' => trans('admin::controller/user.user-management'), 'link' => 'admin/site-user'],
    ['label' => trans('admin::controller/user.manage-users'), 'link' => 'admin/site-user']]; 
/*--}}
@include('admin::partials.breadcrumb')
@include('admin::partials.error', ['type' => 'success', 'message' => session('ok'), 'errors' => $errors])

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-list font-blue-sharp"></i>
                    <span class="caption-subject font-blue-sharp bold uppercase">{!! trans('admin::controller/user.view-users') !!}</span>
                </div>
                <div class="actions">

                    <a href="{{ URL::to('/admin/site-user/create')}}" class="btn blue"><i class="fa fa-plus"></i>{!! trans('admin::messages.add-name', ['name' => trans('admin::messages.user') ]) !!}</a>
                    <a href="{{ URL::to('/admin/site-user/trashed')}}" class="btn red">{!! trans('admin::controller/user.deleted-users') !!}</a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <div class="table-actions-wrapper">
                        {!!  Form::select('bulk_action', $bulkAction, null, ['required', 'class'=>'table-group-action-input form-control input-inline input-small input-sm'])!!}
                        <button class="btn btn-sm yellow table-group-action-submit"><i class="fa fa-check"></i> {!! trans('admin::messages.submit') !!}</button>
                    </div>
                    <table class="table table-striped table-bordered table-hover" id="users_datatable_ajax">
                        <thead>
                            <tr role="row" class="heading">
                                <th width="1%"><input type="checkbox" class="group-checkable"></th>
                                <th width="1%">#</th>
                                <th width="10%">{!! trans('admin::controller/user.avatar') !!}</th>
                                <th width="20%">{!! 'Name ('. trans('admin::controller/user.gender').') ' !!} <br/> {!! trans('admin::controller/user.email') !!}<br/> {!! trans('admin::controller/user.contact') !!}</th>
                                <th width="5%">{!! trans('admin::messages.create-date') !!}</th>
                                <th width="3%">{!! trans('admin::messages.status') !!}</th>
                                <th width="3%">{!! trans('admin::messages.options') !!}</th>
                            </tr>
                            @include('admin::site.users.search')
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>        
</div>
@stop