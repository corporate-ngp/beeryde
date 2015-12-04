<tr role="row" class="filter">
    <td>
    </td>
    <td>
        {!!  Form::select('car_brand_id', ['' => 'Select Car Brand'] +$carBrandList, null, ['required', 'class'=>'select2me form-control form-filter input-sm select2-offscreen'])!!}
    </td>
    <td>
        {!! Form::text('model_name', null, ['class'=>'form-control form-filter']) !!}
    </td>
    <td>
        {!!  Form::select('status', ['' => 'Select',0 => 'Inactive', 1 =>'Active'], null, ['required', 'class'=>'select2me form-control form-filter input-sm select2-offscreen'])!!}
    </td>
    <td>
        <button class="btn btn-sm yellow filter-submit margin-bottom-5" title="Search"><i class="fa fa-search"></i></button>
        <button class="btn btn-sm red filter-cancel margin-bottom-5" title="Reset"><i class="fa fa-times"></i></button>
    </td>
</tr>