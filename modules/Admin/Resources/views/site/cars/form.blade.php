
<div class="form-body">
    <div class="form-group">
        <label class="col-md-3 control-label">Car Brand <span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            {!! Form::select('car_brand_id', [''=>'Select'] + $carBrandList, null,['class'=>'select2me form-control country_id', 'id' => 'country_id', 'data-rule-required'=>'true', 'data-msg-required'=>'Please select Car Brand.']) !!}
        </div>
    </div>
    <div class="form-group" id="state-drop-down">
        @include('admin::site.cars.carmodeldropdown')
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Car User Id <span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            {!! Form::text('user_id', null, ['class'=>'form-control', 'id'=>'name','data-rule-required'=>'true', 'data-msg-required'=>'Please enter User Id.']) !!}
            <span class="help-block">Registered user id</span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Color</label>
        <div class="col-md-4">
            {!! Form::select('color', [''=>'Select Color', 'Black' => 'Black', 'Blue' => 'Blue', 'Brown' => 'Brown', 'Grey' => 'Grey', 'Green' => 'Green', 'Purple' => 'Purple', 'Red' => 'Red', 'Silver' => 'Silver', 'White' => 'White', 'Yellow' => 'Yellow'], null,['class'=>'select2me form-control', 'id' => 'color']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Comfort</label>
        <div class="col-md-4">
            {!! Form::select('comfort', [''=>'Select Comfort', 'Luxury' => 'Luxury', 'Comfortable' => 'Comfortable', 'Economy' => 'Economy'], null,['class'=>'select2me form-control', 'id' => 'comfort']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Seats <span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            {!! Form::select('seats', [''=>'Select Seat', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'], null,['class'=>'select2me form-control', 'id' => 'seats', 'data-rule-required'=>'true', 'data-msg-required'=>'Please select Seats.']) !!}
            <span class="help-block">How many seats are allowed</span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Registration Number <span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            {!! Form::text('registration_number', null, ['class'=>'form-control', 'id'=>'registration_number', 'data-rule-required'=>'true', 'data-msg-required'=>'Please enter Car Registration Number.', 'data-rule-maxlength'=>'50', 'data-msg-maxlength'=>'Registration Number may not have more than {0} letters.', 'maxlength'=>'50']) !!}
            <span class="help-block">Your car registration number</span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label">Rating</label>
        <div class="col-md-4">
            {!! Form::text('rating', null, ['class'=>'form-control', 'id'=>'rating', 'maxlength'=>'20']) !!}
            <span class="help-block">star rating e.g. 5,5,5,5</span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label">Status </label>
        <div class="col-md-4">
            <div class="radio-list">
                <label class="radio-inline">{!! Form::radio('status', '1', true) !!}Active</label>
                <label class="radio-inline">{!! Form::radio('status', '0') !!}Inactive</label>
            </div>
        </div>
    </div>
</div>
