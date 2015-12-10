<label class="col-md-3 control-label">Cars <span class="required" aria-required="true">*</span></label>
<div class="col-md-4" id='state-listing-content'>
    {!! Form::select('car_id', [''=>'Select Car'] + $carList, null,['class'=>'select2me form-control', 'id' => 'car_id', 'data-rule-required'=>'true', 'data-msg-required'=>'Please select car.']) !!}
</div>