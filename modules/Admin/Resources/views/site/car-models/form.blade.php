<div class="form-body">
    <div class="form-group">
        <label class="col-md-3 control-label">Select Car Brand<span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            {!! Form::select('car_brand_id', [''=>'Select Car Brand'] + $carBrandList, null,['class'=>'select2me form-control', 'id' => 'car_brand_id', 'data-rule-required'=>'true', 'data-msg-required'=>'Please select Car Brand.']) !!}
            <span class="help-block">Select car brand.</span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Car Model Name <span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            {!! Form::text('model_name', null, ['class'=>'form-control', 'maxlength' => 200, 'id'=>'model_name', 'data-rule-required'=>'true', 'data-msg-required'=>'Please enter Car Model Name.']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Status </label>
        <div class="col-md-4">
            <div class="radio-list">
                <label class="radio-inline">{!! Form::radio('status', '1', true) !!} Active</label>
                <label class="radio-inline">{!! Form::radio('status', '0') !!} Inactive</label>
            </div>
        </div>
    </div>
</div>