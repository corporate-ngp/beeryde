<div class="portlet box yellow-gold edit-form-main">
    <div class="portlet-title togglelable">
        <div class="caption">
            <i class="fa fa-pencil"></i>Edit Ride 
        </div>
        <div class="tools">
            <a href="javascript:;" class="expand box-expand-form"></a>
        </div>
    </div>
    <div class="portlet-body form">
        {!! Form::model($model, ['route' => ['admin.rides.update', $model->id], 'method' => 'put', 'class' => 'form-horizontal panel config-setting-form','id'=>'edit-city', 'msg' => 'Ride updated successfully.']) !!}
        @include('admin::site.rides.form')
        <div class="form-actions">
            <div class="col-md-6">
                <div class="col-md-offset-6 col-md-9">
                    <button type="submit" class="btn green">Save</button>
                    <button type="button" class="btn default btn-collapse btn-collapse-form-edit">Cancel</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>