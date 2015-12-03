@extends('admin::layouts.master')

@section('template-level-scripts')
@parent
{!! HTML::script( URL::asset('js/admin/site/car-brand.js') ) !!}
@stop

@section('scripts')
@parent

<script>
    jQuery(document).ready(function () {
        siteObjJs.admin.carBrandJs.init();
        siteObjJs.admin.commonJs.boxExpandBtnClick();
    });
</script>
@stop

@section('content')

@include('admin::partials.breadcrumb')
<div id="ajax-response-text"></div>

@if(!empty(Auth::user()->hasAdd))
@include('admin::site.car-brands.create')
@endif

<div id="edit_form">

</div>

<div class="portlet light col-lg-12">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa icon-direction font-blue-sharp"></i>
            <span class="caption-subject font-blue-sharp bold uppercase">View Car Brand</span>
        </div>
        @if(!empty(Auth::user()->hasAdd))
        <div class="actions">
            <a href="javascript:;" class="btn blue btn-add-big btn-expand-form"><i class="fa fa-plus"></i><span class="hidden-480">Add New Car Brand </span></a>
        </div>
        @endif
    </div>
    <div class="portlet-body">
        <div class="table-container">
            <div class="table-actions-wrapper">
                <span></span>
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <input id="data-search" type="search" class="form-control" placeholder="Search">
            </div>
            <table class="table table-striped table-bordered table-hover" id="CarBrandList">
                <thead>
                    <tr role="row" class="heading">
                        <th width='5%'>#</th>
                        <th width='5%'>ID</th>
                        <th>Car Brand</th>
                        <th width='20%'>Status</th>
                        <th width='10%'>Options</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
