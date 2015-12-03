<div class="portlet box yellow-gold edit-form-main">
    <div class="portlet-title togglelable">
        <div class="caption">
            <i class="fa fa-pencil"></i>Edit Car Brand 
        </div>
        <div class="tools">
            <a href="javascript:;" class="expand box-expand-form"></a>
        </div>
    </div>
    <div class="portlet-body form">
        {!! Form::model($carBrand, ['route' => ['admin.car-brands.update', $carBrand->id], 'method' => 'put', 'class' => 'form-horizontal panel country-form','id'=>'edit-car-brand', 'msg' => 'Car Brand updated successfully.']) !!}
        @include('admin::site.car-brands.form')
        <div class="form-actions">
            <div class="col-md-6">
                <div class="col-md-offset-6 col-md-9">
                    <button type="submit" class="btn green">Save</button>
                    <button type="button" class="btn default btn-collapse btn-collapse-form-edit">Cancel</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>