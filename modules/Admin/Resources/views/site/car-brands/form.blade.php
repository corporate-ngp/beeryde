<div class="form-body">
    <div class="form-group">
        <label class="col-md-3 control-label">Car Brand Name <span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            {!! Form::text('brand_name', null, ['class'=>'form-control', 'data-rule-required'=>'true', 'data-msg-required'=>'Please enter Car Brand Name.', 'maxlength'=>'150']) !!}
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