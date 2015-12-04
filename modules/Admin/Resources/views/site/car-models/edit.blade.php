<div class="portlet box yellow-gold edit-form-main">
    <div class="portlet-title togglelable">
        <div class="caption">
            <i class="fa fa fa-pencil"></i>Edit Car Model
        </div>
        <div class="tools">
            <a href="javascript:;" class="expand box-expand-form"></a>
        </div>
    </div>
    <div class="portlet-body form">
        {!! Form::model($model, ['route' => ['admin.car-models.update', $model->id], 'id' => 'edit-state-form', 'method' => 'put', 'class' => 'form-horizontal panel state-form', 'msg' => 'Car Model updated successfully.']) !!}
        @include('admin::site.car-models.form')
        <div class="form-actions">
            <div class="col-md-6">
                <div class="col-md-offset-6 col-md-9">
                    <button class="btn green" type="submit">Save</button>
                    <button class="btn default btn-collapse btn-collapse-form-edit" type="button">Cancel</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>