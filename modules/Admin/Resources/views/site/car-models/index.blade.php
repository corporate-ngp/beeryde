@extends('admin::layouts.master')

@section('template-level-scripts')
@parent
{!! HTML::script( URL::asset('js/admin/site/car-model.js') ) !!}
@stop

@section('styles')
<style>
    input.upper { text-transform: uppercase; }
</style>
@stop

@section('scripts')
@parent
<script>
    jQuery(document).ready(function () {
        siteObjJs.admin.ipCarModelJs.init();
        siteObjJs.admin.commonJs.boxExpandBtnClick();
    });
</script>
@stop

@section('content')

@include('admin::partials.breadcrumb')

<div id="ajax-response-text">
</div>

@if(!empty(Auth::user()->hasAdd))
@include('admin::site.car-models.create')
@endif

<div id="edit_form">
</div>

<div class="portlet light col-lg-12">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-list font-blue-sharp"></i>
            <span class="caption-subject font-blue-sharp bold uppercase">View Car Models</span>
        </div>
        <div class="actions">
            @if(!empty(Auth::user()->hasAdd))
            <a href="javascript:;" class="btn blue btn-add-big btn-expand-form"><i class="fa fa-plus"></i><span class="hidden-480">Add New Car Model </span></a>
            @endif
        </div>
    </div>
    <div class="portlet-body">
        <div class="table-container">
            <table class="table table-striped table-bordered table-hover" id="grid-table">
                <thead>
                    <tr role="row" class="heading">
                        <th width='5%'>#</th>
                        <th>Car Brand Name</th>
                        <th>Car Model Name</th>
                        <th width='20%'>Status</th>
                        <th width='10%'>Options</th>
                    </tr>
                    @include('admin::site.car-models.search')
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
