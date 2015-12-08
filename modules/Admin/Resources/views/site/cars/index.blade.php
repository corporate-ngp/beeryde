@extends('admin::layouts.master')

@section('content')
@include('admin::partials.breadcrumb')
<div id="ajax-response-text"></div>

@if(!empty(Auth::user()->hasAdd))
@include('admin::site.cars.create')
@endif
<div id="edit_form">

</div>
<div class="portlet light col-lg-12">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa icon-social-dribbble font-blue-sharp"></i>
            <span class="caption-subject font-blue-sharp bold uppercase">View Cars</span>
        </div>
        @if(!empty(Auth::user()->hasAdd))
        <div class="actions">
            <a href="javascript:;" class="btn blue btn-add-big btn-expand-form"><i class="fa fa-plus"></i><span class="hidden-480">Add New Car </span></a>
        </div>
        @endif
    </div>
    <div class="portlet-body">
        <div class="table-container">
<!--            <div class="table-actions-wrapper">
                <span>
                </span>

                <table class="">
                    <tbody>
                        {{--
                    <td>
                        {!! Form::select('search_country', [''=>'All'] + $countryList, '',['class'=>'form-control width-auto', 'id' => 'search_country', 'column-index' => '2']) !!}
                    </td>
                        --}}
                    <td>&nbsp;&nbsp;&nbsp;</td>
                    <td>
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input id="data-search" type="search" class="form-control" placeholder="Search">
                    </td>
                    </tbody>
                </table>
            </div>-->
            <table class="table table-striped table-bordered table-hover" id="CarList">
                <thead>
                    <tr role="row" class="heading">
                        <th>#</th>
                        <th width='5%'>ID</th>
                        <th width='20%'>Country</th>
                        <th width='20%'>State</th>
                        <th>Car Name</th>
                        <th width='20%'>Status</th>
                        <th width='10%'>Options</th>
                    </tr>
                    @include('admin::site.cars.search')
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('template-level-scripts')
@parent
{!! HTML::script( URL::asset('js/admin/site/car.js') ) !!}
@stop

@section('scripts')
@parent
<script>
    jQuery(document).ready(function () {
        siteObjJs.admin.carJs.init();
        siteObjJs.admin.commonJs.boxExpandBtnClick();
    });
</script>
@stop