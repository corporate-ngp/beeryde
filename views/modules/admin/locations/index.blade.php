@extends('admin::layouts.master')

@section('page-level-scripts')
@parent
{!! HTML::script( 'http://maps.google.com/maps/api/js?sensor=false' ) !!}
{!! HTML::script( URL::asset('global/plugins/gmaps/gmaps.min.js') ) !!}
{!! HTML::script( URL::asset('global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') ) !!}
@stop

@section('template-level-scripts')
@parent
{!! HTML::script( URL::asset('js/admin/locations.js') ) !!}
@stop

@section('scripts')
@parent
<script>
    jQuery(document).ready(function () {
        siteObjJs.admin.commonJs.boxExpandBtnClick();
        siteObjJs.admin.ipLocationsJs.init();
    });
</script>
@stop

@section('content')
{{--*/ $linkData = \Modules\Admin\Services\Helper\MenuHelper::getRouteByPage() /*--}}
@if(!empty($linkData))
<div class="page-head">
    <div class="page-title">
        <h1>{{$linkData['page_header']}}</h1>
        <h4>{{$linkData['page_text']}}</h4>
    </div>
</div>
<ul class="page-breadcrumb breadcrumb">
    <li><a href="index.html">Admin</a><i class="fa fa-circle"></i></li>
    <li><a href="#">Territories</a><i class="fa fa-circle"></i></li>
    <li><a href="#">{{$linkData['page_header']}}</a></li>
</ul>
@endif
@if ($errors->count())
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {!! HTML::ul($errors->all()) !!}
</div>
@endif

<div class="portlet box green add-form-main">
    <div class="portlet-title togglelable">
        <div class="caption">
            <i class="fa fa-plus"></i>Add New Location 
        </div>
        <div class="tools">
            <a href="javascript:;" class="expand box-expand-form"></a>
        </div>
    </div>
    <div class="portlet-body form display-hide">
        <form action="#" class="form-horizontal locations-form">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Country <span class="required" aria-required="true">*</span></label>
                            <div class="col-md-8">
                                {!!  Form::select('country_id', ['' => 'Select Country', 2 => 'India'], Input::old('country_id'), ['required', 'class'=>'select2me form-control'])!!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">State <span class="required" aria-required="true">*</span></label>
                            <div class="col-md-8">
                                {!!  Form::select('state_id', ['' => 'Select State', 1 => 'Maharastra'], Input::old('state_id'), ['required', 'class'=>'select2me form-control'])!!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">City Name <span class="required" aria-required="true">*</span></label>
                            <div class="col-md-8">
                                {!!  Form::select('city_id', ['' => 'Select City', 1 => 'Pune'], Input::old('city_id'), ['required', 'class'=>'select2me form-control'])!!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Location Name <span class="required" aria-required="true">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="location" value="" maxlength="100">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Address Line 1 <span class="required" aria-required="true">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="address" value="" maxlength="255">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Address Line 2 </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="address1" value="" maxlength="255">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Landmark </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="landmark" value="" maxlength="100">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">ZIP/Pin Code <span class="required" aria-required="true">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="zipcode" value="" maxlength="20">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Pin your Location </label>
                            <div class="col-md-6">
                                <div id="gmap_static" class="gmaps">
                                    <div style="height:100%;overflow:hidden;display:block;background: url(http://maps.googleapis.com/maps/api/staticmap?center=18.520430,73.856743&amp;size=640x300&amp;sensor=true&amp;zoom=9) no-repeat 0% 0%;">
                                        <img src="http://maps.googleapis.com/maps/api/staticmap?center=48.858271,2.294264&amp;size=640x300&amp;sensor=true&amp;zoom=16" style="visibility:hidden" alt=""/>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Status </label>
                            <div class="col-md-8">
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <div class="radio"><input type="radio" checked="checked" value="1" name="status"></div>
                                        Active </label>
                                    <label class="radio-inline">
                                        <div class="radio"><input type="radio" value="0" name="status"></div>
                                        Inactive </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div class="col-md-6">
                    <div class="col-md-offset-4 col-md-9">
                        <button type="submit" class="btn green">Submit</button>
                        <button type="button" class="btn default btn-collapse-form">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="portlet box yellow-gold edit-form-main display-hide">
    <div class="portlet-title togglelable">
        <div class="caption">
            <i class="fa fa-pencil"></i>Edit Location 
        </div>
        <div class="tools">
            <a href="javascript:;" class="expand box-expand-form"></a>
        </div>
    </div>
    <div class="portlet-body form display-hide">
        <form action="#" class="form-horizontal locations-form">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Country <span class="required" aria-required="true">*</span></label>
                            <div class="col-md-8">
                                {!!  Form::select('country_id', ['' => 'Select Country', 2 => 'India'], 2, ['required', 'class'=>'select2me form-control '])!!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">State <span class="required" aria-required="true">*</span></label>
                            <div class="col-md-8">
                                {!!  Form::select('state_id', ['' => 'Select State', 1 => 'Maharastra'], 1, ['required', 'class'=>'select2me form-control'])!!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">City Name <span class="required" aria-required="true">*</span></label>
                            <div class="col-md-8">
                                {!!  Form::select('city_id', ['' => 'Select City', 1 => 'Pune'], 1, ['required', 'class'=>'select2me form-control'])!!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Location Name <span class="required" aria-required="true">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="location" value="Beeryde" maxlength="100">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Address Line 1 <span class="required" aria-required="true">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="address" value="1ST Floor Pride Portal, Senapati Bapat Road" maxlength="255">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Address Line 2 </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="address1" value="Shivaji Housing Society,Shivaji Nagar" maxlength="255">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Landmark </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="landmark" value="Chatashrungi" maxlength="100">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">ZIP/Pin Code <span class="required" aria-required="true">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="zipcode" value="41105" maxlength="20">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Pin your Location </label>
                            <div class="col-md-6">
                                <div id="gmap_static" class="gmaps">
                                    <div style="height:100%;overflow:hidden;display:block;background: url(http://maps.googleapis.com/maps/api/staticmap?center=18.520430,73.856743&amp;size=640x300&amp;sensor=true&amp;zoom=9) no-repeat 0% 0%;">
                                        <img src="http://maps.googleapis.com/maps/api/staticmap?center=48.858271,2.294264&amp;size=640x300&amp;sensor=true&amp;zoom=16" style="visibility:hidden" alt=""/>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Status </label>
                            <div class="col-md-8">
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <div class="radio"><input type="radio" checked="checked" value="1" name="status"></div>
                                        Active </label>
                                    <label class="radio-inline">
                                        <div class="radio"><input type="radio" value="0" name="status"></div>
                                        Inactive </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="col-md-6">
                    <div class="col-md-offset-4 col-md-9">
                        <button type="submit" class="btn green">Save</button>
                        <button type="button" class="btn default btn-collapse-form-edit">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="portlet light col-lg-12">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa icon-pointer font-green-sharp"></i>
            <span class="caption-subject font-green-sharp bold uppercase">View Locations</span>
        </div>
        <div class="actions">
            <a href="javascript:;" class="btn green btn-add-big btn-expand-form"><i class="fa fa-plus"></i><span class="hidden-480">Add New Location </span></a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="table-container">
            <div class="table-actions-wrapper">
                <span>
                </span>
                {!!  Form::select('status', ['' => 'Select',1 => 'Active', 0 =>'Inactive'], Input::old('status'), ['required', 'class'=>'table-group-action-input form-control input-inline input-small input-sm'])!!}

                <button class="btn btn-sm yellow table-group-action-submit"><i class="fa fa-check"></i> Submit</button>
            </div>
            <table class="table table-striped table-bordered table-hover" id="ipLocationsList">
                <thead>
                    <tr role="row" class="heading">
                        <th><input type="checkbox" class="group-checkable"></th>
                        <th width='5%'>#</th>
                        <th width=''>Location Name</th>
                        <th width='20%'>Address</th>
                        <th width='10%'>Country</th>
                        <th width='10%'>State</th>
                        <th width='10%'>City Name</th>
                        <th width='10%'>Status</th>
                        <th width='12%'>Options</th>
                    </tr>
                    @include('admin::locations.search')
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
