<div class="form-body">
    <div class="form-group">
        <label class="col-md-3 control-label">{!! trans('admin::controller/faq-category.name') !!} <span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/faq-category.name')]), 'data-rule-maxlength'=>'150', 'data-rule-maxlength'=>'255', 'data-msg-maxlength'=>trans('admin::messages.error-maxlength', ['name'=>trans('admin::controller/faq-category.name')])]) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">{!! trans('admin::controller/faq-category.position') !!}<span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            {!! Form::text('position', null, ['class'=>'form-control', 'id'=>'position', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/faq-category.position')]) ]) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">{!! trans('admin::controller/faq-category.status') !!}<span class="required" aria-required="true">*</span> </label>
        <div class="col-md-4">
            <div class="radio-list">
                <label class="radio-inline">{!! Form::radio('status', '1', true) !!} {!! trans('admin::messages.active') !!}</label>
                <label class="radio-inline">{!! Form::radio('status', '0') !!} {!! trans('admin::messages.inactive') !!}</label>
            </div>
            <span class="help-block">{!! trans('admin::controller/faq-category.status-help') !!}</span>
        </div>
    </div>
</div>