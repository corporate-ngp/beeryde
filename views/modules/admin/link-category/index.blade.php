@extends('admin::layouts.master')

@section('template-level-scripts')
@parent
{!! HTML::script( URL::asset('global/scripts/datatable.js') ) !!}
{!! HTML::script( URL::asset('js/admin/linkcategory.js') ) !!}
@stop

@section('scripts')
@parent
<script>
    jQuery(document).ready(function() {
        siteObjJs.admin.linkCategory.init();
        siteObjJs.admin.commonJs.boxExpandBtnClick();
    });
</script>
@stop

@section('content')
@include('admin::partials.breadcrumb')
<div id="errorMessage"></div>
@if(!empty(Auth::user()->hasAdd))
<div class="portlet box blue add-form-main">
    <div class="portlet-title togglelable">
        <div class="caption">
            <i class="fa fa-gift"></i>{!! trans('admin::controller/linkcategory.add_new_category') !!}
        </div>
        <div class="tools">
            <a href="javascript:;" class="expand box-expand-form">
            </a>
        </div>
    </div>
    <div class="portlet-body form display-hide">
        @include('admin::link-category.create')
    </div>
</div>
@endif
<div class="portlet box yellow-gold edit-form-main display-hide">
    <div class="portlet-title togglelable">
        <div class="caption">
            <i class="fa fa fa-pencil"></i>{!! trans('admin::controller/linkcategory.edit_category') !!}
        </div>
        <div class="tools">
            <a href="javascript:;" class="expand box-expand-form"></a>
        </div>
    </div>
    <div class="portlet-body form display-hide" id="edit_form">

    </div>
</div>

<div class="portlet light col-lg-12">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-list font-blue-sharp"></i>
            <span class="caption-subject font-blue-sharp bold uppercase">{!! trans('admin::controller/linkcategory.view_categories') !!}</span>
        </div>
        <div class="actions">
            @if(!empty(Auth::user()->hasAdd))
            <a href="javascript:;" class="btn blue btn-add-big btn-expand-form">
                <i class="fa fa-plus"></i><span class="hidden-480">{!! trans('admin::controller/linkcategory.add_new_category') !!} </span>
            </a>
            @endif
        </div>            
    </div>
    <div class="portlet-title">
        <div class="col-md-6"></div>
        <div class="actions pull-right">
            Search: <input id="data-search" type="search" class="form-control input-inline" placeholder="">
        </div>
    </div>
    @if(session()->has('ok'))
    @include('admin::partials/message', ['type' => 'success', 'message' => session('ok')])
    @endif
    <div class="portlet-body">
        <div class="table-container">
            @if(!empty(Auth::user()->hasEdit)) 
            <div class="table-actions-wrapper">
                {!!  Form::select('status', ['' => 'Select', 1 => 'Active', 0 => 'Inactive'], Input::old('status'), ['required', 'class'=>'table-group-action-input form-control input-inline input-small input-sm', 'data-actionType'=>'group', 'data-actionField'=>'status']) !!}
                <button class="btn btn-sm yellow table-group-action-submit"><i class="fa fa-check"></i> Submit</button>
            </div>
            @endif
            <table class="table table-striped table-bordered table-hover" id="linkcategory-table">
                <thead>
                    <tr role="row" class="heading">
                        <th><input type="checkbox" class="group-checkable"></th>
                        <th>Category</th>
                        <th>Display Order</th>
                        <th width="30%">Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</div>
@stop
