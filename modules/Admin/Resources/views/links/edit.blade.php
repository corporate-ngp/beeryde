{!! Form::model($links, ['route' => ['admin.links.update', $links->id], 'method' => 'put', 'class' => 'form-horizontal panel link-management-form','id'=>'linkmanagement-form-update']) !!}
<div class="form-body">
    @include('admin::links.form',['action'=>'update'])
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-offset-4 col-md-9">
                    <button type="submit" name="submit" class="btn green" id='saveBtn'>Save</button>
                    <button type="button" class="btn default btn-collapse-form-edit btn-collapse">Cancel</button>
                </div>
            </div>
        </div>
        <div class="col-md-6"></div>
    </div>
</div>
{!! Form::close() !!}
