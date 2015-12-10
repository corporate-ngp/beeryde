<label class="col-md-3 control-label">Car Model <span class="required" aria-required="true">*</span></label>
<div class="col-md-4" id='state-listing-content'>
    {!! Form::select('car_model_id', [''=>'Select Car Model'] + $carModelList, null,['class'=>'select2me form-control', 'id' => 'state_id', 'data-rule-required'=>'true', 'data-msg-required'=>'Please car model.']) !!}
</div>