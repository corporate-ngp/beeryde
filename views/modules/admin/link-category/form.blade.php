<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label col-md-4">Category Name<span class="required" aria-required="true">*</span></label>
            <div class="col-md-8">
                {!! Form::text('category', null, ['class'=>'form-control','id'=>'category', 'maxlength'=>50 ,'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/linkcategory.category')]), 'data-rule-maxlength'=>'50', 'data-msg-maxlength'=>trans('admin::messages.error-maxlength', ['name'=>trans('admin::controller/linkcategory.category')])]) !!}
                <span class="help-block">E.g. Link Management, Admin User Management</span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-md-4 control-label">Category Icon<span class="required" aria-required="true">*</span></label>
            <div class="col-md-8">
                {!! Form::text('category_icon', null, ['class'=>'form-control','id'=>'category_icon', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/linkcategory.category_icon')]),'readonly'>'readonly']) !!}
                {{--*/ $categoryIcon = ($action=='update')?$linkCategory->category_icon:''; /*--}}
                <p><a href="javascript:;" id="showCategoryIconsPopup">Select Icon</a>&nbsp;&nbsp;<span class="category-icon"><i class="{{$categoryIcon}}"></i></span></p>
                <span class="help-block">Bootstrap icon tag to display before the category name.</span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label col-md-4">Category Description <span class="required" aria-required="true">*</span></label>
            <div class="col-md-8">
                {!! Form::textArea('header_text', null, ['class'=>'form-control','rows'=>3,'id'=>'header_text', 'maxlength'=>255, 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/linkcategory.header_text')]), 'data-rule-maxlength'=>'255', 'data-msg-maxlength'=>trans('admin::messages.error-maxlength', ['name'=>trans('admin::controller/linkcategory.header_text')])]) !!}
                <span class="help-block">Maximum length is 255 characters.</span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label col-md-4">Display Order <span class="required" aria-required="true">*</span></label>
            <div class="col-md-8">
                {!! Form::text('position', null, ['class'=>'form-control','id'=>'position','data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/linkcategory.position')]), 'data-rule-maxlength'=>'10', 'data-msg-maxlength'=>trans('admin::messages.error-maxlength', ['name'=>trans('admin::controller/linkcategory.position')]), 'data-rule-number'=>'10', 'data-msg-number'=>'Please enter numbers only.']) !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-md-4 control-label">Status<span class="required" aria-required="true">*</span></label>
            <div class="col-md-8">
                @if($action === 'create')
                {!! Form::radio('status', '1', true) !!} Active
                @else
                {!! Form::radio('status', '1') !!} Active
                @endif
                {!! Form::radio('status', '0') !!} Inactive
            </div>
        </div>
    </div>
    <div class="col-md-6">
    </div>
</div>
<div id="showCategoryIcons" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Select Category Icon</h4>
            </div>
            <div class="modal-body">
                @include('admin::link-category.categoryicons')
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn default">Close</button>
            </div>
        </div>
    </div>
</div>
