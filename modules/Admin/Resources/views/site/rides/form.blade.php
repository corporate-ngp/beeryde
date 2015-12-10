
<div class="form-body">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group last password-strength">
                <label class="control-label col-md-4">Ride From  <span class="required" aria-required="true">*</span></label>
                <div class="col-md-8">
                    {!! Form::text('ride_from', null, ['class'=>'form-control', 'id'=>'ride_from','data-rule-required'=>'true', 'data-msg-required'=>'Please enter Ride From.']) !!}
                    <span class="help-block">Source Name. e.g. From where you are starting ride</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Ride To<span class="required" aria-required="true">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('ride_to', null, ['class'=>'form-control', 'id'=>'ride_to','data-rule-required'=>'true', 'data-msg-required'=>'Please enter Ride To.']) !!}
                    <span class="help-block">Destination Name. e.g. To where you are ending ride</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group last password-strength">
                <label class="control-label col-md-4">Price Per Person <span class="required" aria-required="true">*</span></label>
                <div class="col-md-8">
                    {!! Form::text('price', null, ['class'=>'form-control', 'id'=>'price','data-rule-required'=>'true', 'data-msg-required'=>'Please enter Price Per Person']) !!}
                    <span class="help-block">Quoted price per person</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Ride Date <span class="required" aria-required="true">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('ride_date', null, ['class'=>'form-control', 'id'=>'ride_date','data-rule-required'=>'true', 'data-msg-required'=>'Please enter Ride Date.']) !!}
                    <span class="help-block">Format Y-m-d H:s:i, e.g. 2015-12-12 09:30:00</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group last password-strength">
                <label class="control-label col-md-4">User Id <span class="required" aria-required="true">*</span></label>
                <div class="col-md-8">
                    {!! Form::text('user_id', null, ['class'=>'form-control', 'id'=>'user_id','data-rule-required'=>'true', 'data-msg-required'=>'Please enter User Id.']) !!}
                    <span class="help-block">Registered user id</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Car Id<span class="required" aria-required="true">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('car_id', null, ['class'=>'form-control', 'id'=>'car_id','data-rule-required'=>'true', 'data-msg-required'=>'Please enter Car Id.']) !!}
                    <span class="help-block">Your Car Id</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group last password-strength">
                <label class="control-label col-md-4">Return Ride </label>
                <div class="col-md-8">
                    {!! Form::checkbox('return_ride', 1, null, ['id' => 'return_ride', 'class' => 'form-control']) !!}
                    <span class="help-block">If return type of ride</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Return Date</label>
                <div class="col-md-7">
                    {!! Form::text('ride_return_date', null, ['class'=>'form-control', 'id'=>'ride_return_date']) !!}
                    <span class="help-block">Return Date</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group last password-strength">
                <label class="control-label col-md-4">Multiple Times Travels </label>
                <div class="col-md-8">
                    {!! Form::checkbox('multiple_times_travels', 1, null, ['id' => 'multiple_times_travels', 'class' => 'form-control']) !!}
                    <span class="help-block">If multiple times travels</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Multiple Times Travels Dates</label>
                <div class="col-md-7">
                    {!! Form::text('multiple_times_travels_dates', null, ['class'=>'form-control', 'id'=>'multiple_times_travels_dates']) !!}
                    <span class="help-block">Enter Comma separated Dates of multiple time travel</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group last password-strength">
                <label class="control-label col-md-4">Seats</label>
                <div class="col-md-8">
                    {!! Form::select('seats', [''=>'Select Seat', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'], null,['class'=>'select2me form-control country_id', 'id' => 'seats', 'data-rule-required'=>'true', 'data-msg-required'=>'Please select Seats.']) !!}
                    <span class="help-block">How many seats are allowed</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Luggage Size </label>
                <div class="col-md-7">
                    {!! Form::select('luggage_size', [''=>'Select Luggage Size', 'No luggage' => 'No luggage', 'light' => 'light', 'medium' => 'medium', 'heavy' => 'heavy'], null,['class'=>'select2me form-control country_id', 'id' => 'luggage_size']) !!}
                    <span class="help-block">Your Luggage Size</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group last password-strength">
                <label class="control-label col-md-4">Waiting Time</label>
                <div class="col-md-8">
                    {!! Form::select('waiting_time', [''=>'Select Waiting Time', 'No waiting' => 'No waiting', 'min 15 min' => 'min 15 min', 'max 30min' => 'max 30min', 'max 1hr' => 'max 1hr'], null,['class'=>'select2me form-control country_id', 'id' => 'waiting_time']) !!}
                    <span class="help-block">Waiting Time</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Detour Time </label>
                <div class="col-md-7">
                    {!! Form::select('detour_time', [''=>'Select Detour Time', 'No detour' => 'No detour', 'min 15 min' => 'min 15 min', 'max 30min' => 'max 30min', 'max 1hr' => 'max 1hr'], null,['class'=>'select2me form-control country_id', 'id' => 'detour_time']) !!}
                    <span class="help-block">Detour Time</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group last password-strength">
                <label class="control-label col-md-4">Ride Preference</label>
                <div class="col-md-8">
                    {!! Form::select('ride_preference', [''=>'Select Waiting Time', 'male/female' => 'male/female', 'allow-female' => 'allow-female', 'male' => 'male', 'both' => 'both'], null,['class'=>'select2me form-control country_id', 'id' => 'ride_preference']) !!}
                    <span class="help-block">Ride Preference</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Ride Purpose </label>
                <div class="col-md-7">
                    {!! Form::text('ride_purpose', null, ['class'=>'form-control', 'id'=>'ride_purpose', 'maxlength' =>'255']) !!}
                    <span class="help-block">Ride Purpose</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group last password-strength">
                <label class="control-label col-md-4">Pets Allow </label>
                <div class="col-md-8">
                    {!! Form::checkbox('pets_allow', 1, null, ['id' => 'pets_allow', 'class' => 'form-control']) !!}
                    <span class="help-block">Is Pets Allow </span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Smoking Allow</label>
                <div class="col-md-7">
                    {!! Form::checkbox('smoking_allow', 1, null, ['id' => 'smoking_allow', 'class' => 'form-control']) !!}
                    <span class="help-block">Is Smoking Allow </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group last password-strength">
                <label class="control-label col-md-4">Is Auto Approval Booking </label>
                <div class="col-md-8">
                    {!! Form::checkbox('auto_approval_booking', 1, null, ['id' => 'auto_approval_booking', 'class' => 'form-control']) !!}
                    <span class="help-block">Is Auto Approval Booking</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Status</label>
                <div class="col-md-7">
                    <div class="radio-list">
                        <label class="radio-inline">{!! Form::radio('status', '1', true) !!}Active</label>
                        <label class="radio-inline">{!! Form::radio('status', '0') !!}Inactive</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group last password-strength">
                <label class="control-label col-md-4">Boarding Point 1</label>
                <div class="col-md-8">
                    {!! Form::text('boarding_point1', null, ['class'=>'form-control', 'id'=>'boarding_point1', 'maxlength' =>'255']) !!}
                    <span class="help-block">Boarding Point 1</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Boarding Point 1 Fair </label>
                <div class="col-md-7">
                    {!! Form::text('boarding_point1_fair', null, ['class'=>'form-control', 'id'=>'boarding_point1_fair', 'maxlength' =>'10']) !!}
                    <span class="help-block">Boarding Point 1 Fair</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group last password-strength">
                <label class="control-label col-md-4">Boarding Point 2</label>
                <div class="col-md-8">
                    {!! Form::text('boarding_point2', null, ['class'=>'form-control', 'id'=>'boarding_point2', 'maxlength' =>'255']) !!}
                    <span class="help-block">Boarding Point 2</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Boarding Point 2 Fair </label>
                <div class="col-md-7">
                    {!! Form::text('boarding_point2_fair', null, ['class'=>'form-control', 'id'=>'boarding_point2_fair', 'maxlength' =>'10']) !!}
                    <span class="help-block">Boarding Point 2 Fair</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group last password-strength">
                <label class="control-label col-md-4">Boarding Point 3</label>
                <div class="col-md-8">
                    {!! Form::text('boarding_point3', null, ['class'=>'form-control', 'id'=>'boarding_point3', 'maxlength' =>'255']) !!}
                    <span class="help-block">Boarding Point 3</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Boarding Point 3 Fair </label>
                <div class="col-md-7">
                    {!! Form::text('boarding_point3_fair', null, ['class'=>'form-control', 'id'=>'boarding_point3_fair', 'maxlength' =>'10']) !!}
                    <span class="help-block">Boarding Point 3 Fair</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group last password-strength">
                <label class="control-label col-md-4">Boarding Point 4</label>
                <div class="col-md-8">
                    {!! Form::text('boarding_point4', null, ['class'=>'form-control', 'id'=>'boarding_point4', 'maxlength' =>'255']) !!}
                    <span class="help-block">Boarding Point 4</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Boarding Point 4 Fair </label>
                <div class="col-md-7">
                    {!! Form::text('boarding_point4_fair', null, ['class'=>'form-control', 'id'=>'boarding_point4_fair', 'maxlength' =>'10']) !!}
                    <span class="help-block">Boarding Point 4 Fair</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group last password-strength">
                <label class="control-label col-md-4">Boarding Point 5</label>
                <div class="col-md-8">
                    {!! Form::text('boarding_point5', null, ['class'=>'form-control', 'id'=>'boarding_point5', 'maxlength' =>'255']) !!}
                    <span class="help-block">Boarding Point 5</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Boarding Point 5 Fair </label>
                <div class="col-md-7">
                    {!! Form::text('boarding_point5_fair', null, ['class'=>'form-control', 'id'=>'boarding_point5_fair', 'maxlength' =>'10']) !!}
                    <span class="help-block">Boarding Point 5 Fair</span>
                </div>
            </div>
        </div>
    </div>


</div>
