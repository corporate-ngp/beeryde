<div class="form-body">
    <div class="form-group">
        <label class="col-md-3 control-label">Country Name <span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            {!! Form::text('name', null, ['class'=>'form-control', 'data-rule-required'=>'true', 'data-msg-required'=>'Please enter Country Name.', 'maxlength'=>'200']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">ISO Code 2 <span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            {!! Form::text('iso_code_2', null, ['class'=>'form-control', 'data-rule-required'=>'true', 'data-msg-required'=>'Please enter ISO Code 2.', 'maxlength'=>'2', 'minlength'=>'2']) !!}
            <span class="help-block">2 character ISO Code.</span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">ISO Code 3 <span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            {!! Form::text('iso_code_3', null, ['class'=>'form-control', 'data-rule-required'=>'true', 'data-msg-required'=>'Please enter ISO Code 3.', 'maxlength'=>'3', 'minlength'=>'3']) !!}
            <span class="help-block">3 character ISO Code.</span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">ISD Code <span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            {!! Form::text('isd_code', null, ['class'=>'form-control', 'maxlength'=>'7', 'data-rule-required'=>'true', 'data-msg-required'=>'Please enter ISD Code.', 'maxlength'=>'7']) !!}
            <span class="help-block">ISD Code.</span>
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