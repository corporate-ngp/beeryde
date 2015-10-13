@extends('admin::layouts.master')

@section('page-level-styles')
@parent
{!! HTML::style( URL::asset('global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') ) !!}
{!! HTML::style( URL::asset('global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') ) !!}
{!! HTML::style( URL::asset('global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') ) !!}
@stop

@section('page-level-scripts')
@parent
{!! HTML::script( URL::asset('global/plugins/datatables/media/js/jquery.dataTables.min.js') ) !!}
{!! HTML::script( URL::asset('global/plugins/datatables/media/js/dataTables.bootstrap.js') ) !!}
{!! HTML::script( URL::asset('global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ) !!}
{!! HTML::script( URL::asset('global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') ) !!}
{!! HTML::script( URL::asset('global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') ) !!}
@stop

@section('template-level-scripts')
@parent
{!! HTML::script( URL::asset('global/scripts/datatable.js') ) !!}
{!! HTML::script( URL::asset('js/admin/login-logs.js') ) !!}
@stop

@section('scripts')
@parent
<script>
    jQuery(document).ready(function() {
        gridTable.init();
        siteObjJs.admin.commonJs.boxExpandBtnClick();
    });
</script>
@stop

@section('content')
@include('admin::partials.breadcrumb')
<div class="portlet light col-lg-12">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-list font-green-sharp"></i>
            <span class="caption-subject font-green-sharp bold uppercase">{!! trans('admin::controller/loginlogs.view_user_login_details')!!}</span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="table-container">
            <div class="table-actions-wrapper">
                {!!  Form::select('status', $groupActions, null, ['required', 'class'=>'table-group-action-input form-control input-inline input-small input-sm', 'data-actionType'=>'group','data-action'=>'delete', 'data-actionField'=>'status']) !!}
                <button class="btn btn-sm yellow table-group-action-submit"><i class="fa fa-check"></i> Submit</button>
            </div>
            <table class="table table-striped table-bordered table-hover" id="grid-table">
                <thead>
                    <tr role="row" class="heading">
                        <th><input type="checkbox" class="group-checkable"></th>
                        <th>Username</th>
                        <th>IP Address</th>
                        <th>Login Time</th>
                        <th>Last Access Time</th>
                        <th>Logout Time</th>
                        <th>Action</th>
                    </tr>
                    <tr role="row" class="filter">
                        <th></th>
                        <td><input type="text" class="form-control form-filter input-sm" name="user_id"></td>
                        <td>{!! Form::text('ip_address', null, ['class'=>'form-control form-filter input-sm']) !!}</td>
                        <td>
                            <div class="input-group date form_datetime margin-bottom-5" data-date="{{date('Y-m-d h:i:s')}}">
                                {!! Form::text('login_in_time_from', null, ['class'=>'form-control form-filter input-sm','placeholder'=>'From','disabled'=>'disabled']) !!}
                                <span class="input-group-btn">
                                    <button class="btn default date-reset btn-sm" type="button"><i class="fa fa-times"></i></button>
                                    <button class="btn default date-set btn-sm" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                            <div class="input-group date form_datetime" data-date="{{date('Y-m-d h:i:s')}}">
                                {!! Form::text('login_in_time_to', null, ['class'=>'form-control form-filter input-sm','placeholder'=>'To','disabled'=>'disabled']) !!}
                                <span class="input-group-btn">
                                    <button class="btn default date-reset btn-sm" type="button"><i class="fa fa-times"></i></button>
                                    <button class="btn default date-set btn-sm" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="input-icon margin-bottom-5">
                                <i class="fa fa-clock-o"></i>
                                {!! Form::text('access_time_from', null, ['class'=>'form-control timepicker form-filter timepicker-default input-sm']) !!}
                            </div>
                            <div class="input-icon">
                                <i class="fa fa-clock-o"></i>
                                {!! Form::text('access_time_to', null, ['class'=>'form-control timepicker form-filter timepicker-default input-sm']) !!}
                            </div>
                        </td>
                        <td>
                            <div class="input-group date form_datetime margin-bottom-5" data-date="{{date('Y-m-d h:i:s')}}">
                                {!! Form::text('logout_out_time_from', null, ['class'=>'form-control form-filter input-sm','placeholder'=>'From','disabled'=>'disabled']) !!}
                                <span class="input-group-btn">
                                    <button class="btn default date-reset btn-sm" type="button"><i class="fa fa-times"></i></button>
                                    <button class="btn default date-set btn-sm" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                            <div class="input-group date form_datetime" data-date="{{date('Y-m-d h:i:s')}}">
                                {!! Form::text('logout_out_time_to', null, ['class'=>'form-control form-filter input-sm','placeholder'=>'To','disabled'=>'disabled']) !!}
                                <span class="input-group-btn">
                                    <button class="btn default date-reset btn-sm" type="button"><i class="fa fa-times"></i></button>
                                    <button class="btn default date-set btn-sm" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-sm yellow filter-submit margin-bottom-5" title="Search"><i class="fa fa-search"></i></button>
                            <button class="btn btn-sm red blue filter-cancel margin-bottom-5" title="Reset"><i class="fa fa-times"></i></button>
                        </td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@stop