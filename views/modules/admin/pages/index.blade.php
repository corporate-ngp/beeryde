@extends('admin::layouts.master')

@section('title', 'Manage Pages')

@section('content')
@include('admin::partials.breadcrumb')
<div id="errorMessage"></div>
@if(!empty(Auth::user()->hasAdd))
<div class="portlet box blue add-form-main">
    <div class="portlet-title togglelable">
        <div class="caption">
            <i class="fa fa-gift"></i>{!! trans('admin::controller/page.add_new_page')!!}
        </div>
        <div class="tools">
            <a href="javascript:;" class="expand box-expand-form">
            </a>
        </div>
    </div>
    <div class="portlet-body form display-hide">
        @include('admin::pages.create')
    </div>
</div>
@endif
<div class="portlet box yellow-gold edit-form-main display-hide">
    <div class="portlet-title togglelable">
        <div class="caption">
            <i class="fa fa fa-pencil"></i>{!! trans('admin::controller/page.edit_page')!!}
        </div>
        <div class="tools">
            <a href="javascript:;" class="expand box-expand-form"></a>
        </div>
    </div>
    <div class="portlet-body form display-hide" id="edit_form">

    </div>
</div>

<div class="row">
    <div class="col-md-12 manage-pages">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-files-o font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">{!! trans('admin::controller/page.view_pages')!!}</span>
                </div>
                <div class="actions">
                    @if(!empty(Auth::user()->hasAdd))
                    <a href="javascript:;" class="btn blue btn-add-big btn-expand-form">
                        <i class="fa fa-plus"></i><span class="hidden-480">{!! trans('admin::controller/page.add_new_page')!!} </span>
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
            <div class="portlet-body">
                <div class="table-container">
                    @if(!empty(Auth::user()->hasEdit) && !empty(Auth::user()->hasDelete)) 
                    <div class="table-actions-wrapper">
                        {!!  Form::select('status', ['' => 'Select', 1 => 'Active', 0 => 'Inactive'], Input::old('status'), ['required', 'class'=>'table-group-action-input form-control input-inline input-small input-sm', 'data-actionType'=>'group', 'data-actionField'=>'status']) !!}
                        <button class="btn btn-sm yellow table-group-action-submit"><i class="fa fa-check"></i> Submit</button>
                    </div>
                    @endif
                    <table class="table table-striped table-bordered table-hover" id="pages_datatable_ajax">
                        <thead>
                            <tr role="row" class="heading">
                                <th><input type="checkbox" class="group-checkable"></th>
                                <th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
                                <th>Page Name / Page Slug</th>
                                <th>URL</th>
                                <th>Description</th>
                                <th width="10%">Status</th>
                                <th width="10%" class="sorting_disabled">Options</th>
                            </tr>
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


@section('template-level-scripts')
@parent
{!! HTML::script( URL::asset('js/admin/pages.js') ) !!}
@stop

@section('template-level-scripts')
@parent
{!! HTML::script( URL::asset('admintheme/tinymce/tinymce.min.js') ) !!}
{!! HTML::script( URL::asset('admintheme/tinymce/tinymce_editor.js') ) !!}
{!! HTML::script( URL::asset('global/plugins/jquery.slugify.js') ) !!}
@stop

@section('scripts')
@parent
<script>
    jQuery(document).ready(function() {
        siteObjJs.admin.pages.init();
        siteObjJs.admin.commonJs.boxExpandBtnClick();
    });
</script>
@stop