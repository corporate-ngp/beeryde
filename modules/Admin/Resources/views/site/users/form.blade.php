@section('global-level-styles')
@parent
{!! HTML::style( URL::asset('global/plugins/uniform/css/uniform.default.min.css') ) !!}
@stop

@section('page-level-styles')
@parent
{!! HTML::style( URL::asset('global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') ) !!}
{!! HTML::style( URL::asset('css/admin/admin-user.css') ) !!}

@stop

@section('page-level-scripts')
@parent
{!! HTML::script( URL::asset('global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') ) !!}
{!! HTML::script( URL::asset('global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') ) !!}
{!! HTML::script( URL::asset('global/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js') ) !!}
{!! HTML::script( URL::asset('global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') ) !!}
{!! HTML::script( URL::asset('js/admin/validate-users.js') ) !!}
@stop

@section('scripts')
@parent
<script>
    jQuery(document).ready(function () {
        siteObjJs.admin.validateUserJs.init();
        siteObjJs.admin.validateUserJs.whatIsIpTitle = "{!! trans('admin::controller/user.skip-ip-what') !!}";
        siteObjJs.admin.validateUserJs.whatIsIpDesc = "{!! trans('admin::controller/user.skip-ip-help') !!}";
        siteObjJs.admin.validateUserJs.confirmRemoveImage = "{!! trans('admin::messages.confirm-remove-image') !!}";
        siteObjJs.admin.validateUserJs.maxFileSize = "{!! trans('admin::messages.max-file-size') !!}";
        siteObjJs.admin.validateUserJs.mimes = "{!! trans('admin::messages.mimes') !!}";
    });
</script>
@stop


<div class="form-body">
    <h3 class="form-section">{!! trans('admin::controller/user.user-info') !!}</h3>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">{!! trans('admin::controller/user.email') !!}<span class="required" aria-required="true">*</span></label>
                <div class="col-md-8">
                    <div class="input-group">
                        {!! Form::hidden('remove', '', ['class'=>'form-control', 'id'=>'remove']) !!}
                        @if($from == 'create')
                        {!! Form::text('email', null, ['id' => 'email', 'class' => 'form-control', 'data-rule-email' => 'true', 'data-msg-required' => trans('admin::messages.required-enter', ['name' => trans('admin::controller/user.email')]), 'maxlength' => '100']) !!}
                        @else 
                        {!! Form::text('email', null, ['disabled' => 'disabled', 'id' => 'email', 'class' => 'form-control', 'data-rule-required' => 'true', 'data-msg-required' => trans('admin::messages.required-enter', ['name' => trans('admin::controller/user.email')]), 'maxlength' => '100']) !!}
                        @endif 
                    </div> 
                </div>
            </div>
        </div>
        <div class="col-md-6">&nbsp;</div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group last password-strength">
                <label class="control-label col-md-4">{!! trans('admin::controller/user.new-password') !!} <span class="required" aria-required="true">*</span></label>
                <div class="col-md-8">
                    <?php
                    $passwordRule = true;
                    if ($from == 'update') {
                        $passwordRule = false;
                    }

                    ?>
                    {!! Form::password('password', ['id' => 'password_strength', 'class' => 'form-control placeholder-no-fix', 'data-rule-required' => "$passwordRule", 'data-msg-required' => trans('admin::messages.required-enter', ['name' => trans('admin::controller/user.password')]), 'maxlength' => '100', 'minlength' => '8']) !!}

                    @if($from == 'update')
                    <span class="help-block">{!! trans('admin::controller/user.password-edit-help') !!}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">{!! trans('admin::messages.re-type', ['name'=> trans('admin::controller/user.new-password')]) !!} <span class="required" aria-required="true">*</span></label>
                <div class="col-md-7">
                    {!! Form::password('password_confirmation', ['class' => 'form-control placeholder-no-fix', 'data-rule-required' => "$passwordRule", 'data-msg-required' => trans('admin::messages.required-enter', ['name' => trans('admin::controller/user.confirm-password')]), 'data-msg-equalTo' => trans('admin::controller/user.password-confirmed'), 'data-rule-equalTo' => '#password_strength', 'maxlength' => '100']) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Name <span class="required" aria-required="true">*</span></label>
                <div class="col-md-8">
                    {!! Form::text('name', null, ['id' => 'name', 'class' => 'form-control', 'data-rule-required' => 'true', 'data-msg-required' => 'Please enter Name', 'minlength' => '2', 'maxlength' => '120']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-5 control-label">Contact Number <span class="required" aria-required="true">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('contact', null, ['id' => 'user_phone', 'class' => 'form-control', 'data-rule-required' => 'true', 'data-msg-required' => trans('admin::messages.required-enter', ['name' => trans('admin::controller/user.contact')]), 'minlength' => '10', 'maxlength' => '20']) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group ">
                <label class="control-label col-md-4">{!! trans('admin::controller/user.avatar') !!}</label>
                <div class="col-md-8">
                    <p>{!! trans('admin::controller/user.select-image-help') .' '.trans('admin::messages.mimes').' '.trans('admin::messages.max-file-size') !!}</p>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new user-form-img margin-bottom-10">  
                            @if($from == 'update' && !empty($user->avatar))
                            {!! \Modules\Admin\Services\Helper\ImageHelper::getUserAvatar($user->id, $user->avatar) !!}
                            @else
                            {!! HTML::image(URL::asset('images/default-user-icon-profile.png '), 'default-img', ['class' => 'img-thumbnail img-responsive']); !!}
                            @endif
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                        <div id='file-error' class='text-danger margin-bottom-10 bold'></div>
                        <div class="inline">&nbsp;
                            <span class="btn default btn-file">
                                <span class="fileinput-new">
                                    @if($from == 'update' && !empty($user->avatar))
                                    {!! trans('admin::controller/user.change-image') !!}
                                    @else 
                                    {!! trans('admin::controller/user.select-image') !!}
                                    @endif
                                </span>
                                <span class="fileinput-exists">{!! trans('admin::messages.change') !!} </span>
                                {!! Form::file('thefile', ['id' => 'avatar', 'class' => 'field']) !!}
                            </span>
                            <span class="fileinput-new">&nbsp;
                                @if(!empty($user->avatar))
                                <a href="javascript:;" class="btn default remove-image" >
                                    {!! trans('admin::controller/user.remove-image') !!} </a>
                                @endif
                            </span>&nbsp;
                            <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput">
                                {!! trans('admin::messages.remove') !!} </a>
                        </div>
                    </div>
                    <div class="clearfix margin-top-15 margin-bottom-15">
                        <span class="label label-danger">{!! trans('admin::messages.note') !!} </span>
                        <span style="margin-left:10px;">{!! trans('admin::controller/user.support-image-help') !!}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-5 control-label">{!! trans('admin::controller/user.gender') !!} <span class="required" aria-required="true">*</span></label>
                <div class="col-md-7">
                    <div class="radio-list">
                        <label class="radio-inline">
                            {!! Form::radio('gender', 1, null, ['class' => 'form-control', 'data-rule-required' => 'true']) !!} {!! trans('admin::controller/user.male') !!}
                        </label>
                        <label class="radio-inline">
                            {!! Form::radio('gender', 0, null, ['class' => 'form-control']) !!} {!! trans('admin::controller/user.female') !!}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Date Of Birth</label>
                <div class="col-md-8">
                    {!! Form::text('dob', null, ['id' => 'dob', 'class' => 'form-control']) !!}
                    <span class="help-block">format: yyyy-mm-dd  e.g. 2015-03-21</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-5 control-label">Star Ratings</label>
                <div class="col-md-7">
                    {!! Form::text('ratings', null, ['id' => 'ratings', 'class' => 'form-control']) !!}
                    <span class="help-block">star rating e.g. 5,5,5,5</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">SMS Notification</label>
                <div class="col-md-8">
                    {!! Form::checkbox('sms_notification', 1, null, ['id' => 'sms_notification', 'class' => 'form-control']) !!}
                    <span class="help-block">SMS Notification yes/no</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-5 control-label">Push Notification</label>
                <div class="col-md-7">
                    {!! Form::checkbox('push_notification', 1, null, ['id' => 'push_notification', 'class' => 'form-control']) !!}
                    <span class="help-block">Push Notification yes/no</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Occupation</label>
                <div class="col-md-8">
                    {!! Form::text('occupation', null, ['id' => 'occupation', 'class' => 'form-control']) !!}
                    <span class="help-block"></span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-5 control-label">Profession Details</label>
                <div class="col-md-7">
                    {!! Form::text('profession_details', null, ['id' => 'profession_details', 'class' => 'form-control']) !!}
                    <span class="help-block"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Emergency Contact Number</label>
                <div class="col-md-8">
                    {!! Form::text('emergency_contact_1', null, ['id' => 'emergency_contact_1', 'class' => 'form-control', 'minlength' => '10', 'maxlength' => '20']) !!}
                    <span class="help-block"></span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-5 control-label">Alternate Emergency Number</label>
                <div class="col-md-7">
                    {!! Form::text('emergency_contact_2', null, ['id' => 'emergency_contact_2', 'class' => 'form-control', 'minlength' => '10', 'maxlength' => '20']) !!}
                    <span class="help-block"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">ID Proof Type</label>
                <div class="col-md-8">
                    {!! Form::text('id_proof_type', null, ['id' => 'id_proof_type', 'class' => 'form-control']) !!}
                    <span class="help-block">e.g. PAN card, Adhar card, Passport</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-5 control-label">ID Proof</label>
                <div class="col-md-7">
                    {!! Form::text('id_proof', null, ['id' => 'id_proof', 'class' => 'form-control']) !!}
                    <span class="help-block">Id Proof File</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Music</label>
                <div class="col-md-8">
                    {!! Form::checkbox('music', 1, null, ['id' => 'music', 'class' => 'form-control']) !!}
                    <span class="help-block">Music yes/no</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-5 control-label">Smoking</label>
                <div class="col-md-7">
                    {!! Form::checkbox('smoking', 1, null, ['id' => 'smoking', 'class' => 'form-control']) !!}
                    <span class="help-block">Smoking yes/no</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Corporate Email Address</label>
                <div class="col-md-8">
                    {!! Form::text('corporate_email', null, ['id' => 'corporate_email', 'class' => 'form-control', 'data-rule-email' => 'true', 'data-msg-required' => 'Please enter valid email address', 'maxlength' => '100']) !!}
                    <span class="help-block"></span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-4 control-label">Mobile Verification</label>
                <div class="col-md-8">
                    {!! Form::text('mobile_verification', null, ['id' => 'mobile_verification', 'class' => 'form-control']) !!}
                    <span class="help-block">First send SMS code upto 10 digit max and enter SMS code and after that put 1 for verification success</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Email Verification</label>
                <div class="col-md-7">
                    {!! Form::text('email_verification', null, ['id' => 'email_verification', 'class' => 'form-control']) !!}
                    <span class="help-block">First send email and verification code upto 10 digit max and after that put 1 for verification success</span>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Facebook ID</label>
                <div class="col-md-8">
                    {!! Form::text('facebook_id', null, ['id' => 'facebook_id', 'class' => 'form-control']) !!}
                    <span class="help-block">Facebook API returns facebook id for each registered user</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-5 control-label">Googleplus ID</label>
                <div class="col-md-7">
                    {!! Form::text('googleplus_id', null, ['id' => 'googleplus_id', 'class' => 'form-control']) !!}
                    <span class="help-block">Google Plus API returns googleplus id for each registered user</span>
                </div>
            </div>
        </div>
    </div>


    <hr />

    <div class="form-actions">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-offset-4 col-md-8">
                        <button type="submit" class="btn blue" name="submit">{!! trans('admin::messages.save') !!}</button>
                        @if($from == 'create')
                        <button type="submit" name="submit_save" class="btn blue">{!! trans('admin::messages.save-add') !!}</button>
                        @endif
                        <a href='{{URL::to("/admin/site-user")}}' class="btn default btn-collapse-form">{!! trans('admin::messages.cancel') !!}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
            </div>
        </div>
    </div>
</div>

