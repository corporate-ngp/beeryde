
<div class="form-body">
    <div class="form-group">
        <label class="col-md-3 control-label">Country <span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            {!! Form::select('country_id', [''=>'Select'] + $countryList, null,['class'=>'select2me form-control country_id', 'id' => 'country_id', 'data-rule-required'=>'true', 'data-msg-required'=>'Please select Country.']) !!}
        </div>
    </div>
    <div class="form-group" id="state-drop-down">
        @include('admin::city.statedropdown')
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">City Name <span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name','data-rule-required'=>'true', 'data-msg-required'=>'Please enter City Name.', 'data-rule-maxlength'=>'200', 'data-msg-maxlength'=>'Description may not have more than {0} letters.', 'maxlength'=>'200']) !!}
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
