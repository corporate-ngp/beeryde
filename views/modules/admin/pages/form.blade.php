<div class="form-body text-left">
    <h3 class="form-section">Basic Information</h3>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Page Name<span class="required"> * </span></label>
                <div class="col-md-8">
                    {!! Form::text('page_name', null, ['class'=>'form-control', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/managePages.page_name')]),'id'=>'page_name']) !!}
                    <span class="help-block">
                        Descriptive name to identify the page. Eg. Home, About Us etc.
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Slug<span class="required"> * </span></label>
                <div class="col-md-8">
                    {!! Form::text('slug', null, ['class'=>'form-control slug', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/managePages.slug')])]) !!}
                    <span class="help-block">
                        Slug (in small case without white spaces) to uniquely identify this page.  Eg. home, about-us etc.
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-2">Page Description</label>
                <div class="col-md-10">
                    {!! Form::textarea('page_desc', null, array('style'=>'resize:none;','rows'=>'2','class'=>'form-control')) !!}
                    <span class="help-block">Brief text to describe what this page does.</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-2">Page URL<span class="required"> * </span></label>
                <div class="col-md-10">
                    <span class="url-span text-muted col-md-3">{{ url("/") }}/</span>
                    <div class="col-md-4 padding-zero">
                        {!! Form::text('page_url', null, ['class'=>'form-control padding-zero', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/managePages.page_url')]),'id'=>'page_url']) !!}
                        <span class="help-block">Eg. home, about-us, contact-us etc.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h3 class="form-section">Meta Information</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-2">Browser Title<span class="required"> * </span></label>

                <div class="col-md-10">
                    {!! Form::text('browser_title', null, ['class'=>'form-control', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/managePages.browser_title')]) ])!!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-2">Meta Keywords<span class="required"> * </span></label>
                <div class="col-md-10">
                    {!! Form::text('meta_keywords', null, ['class'=>'form-control', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/managePages.meta_keywords')] )]) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-2">Meta Description<span class="required"> * </span></label>
                <div class="col-md-10">
                    {!! Form::text('meta_description', null, ['class'=>'form-control', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/managePages.meta_description')] )]) !!}
                </div>
            </div>
        </div>
    </div>
    <h3 class="form-section">Page Content</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-2">Page Content<span class="required"> * </span></label>
                <div class="col-md-10">
                    {!! Form::textarea('page_content', null, ['class'=>'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
    <h3 class="form-section">Other Details</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-2">Status<span class="required"> * </span></label>
                <div class="col-md-10">
                    @if($action === 'create')
                    {!! Form::radio('status', '1', true) !!} Active
                    @else
                    {!! Form::radio('status', '1') !!} Active
                    @endif
                    {!! Form::radio('status', '0') !!} Inactive
                </div>
            </div>
        </div>
    </div>
</div>
