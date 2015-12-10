<tr role="row" class="filter">
    <td>
    </td>
    <td>
    </td>
    <td>
        {!! Form::text('user_id', null, ['class'=>'form-control form-filter']) !!}
    </td>
    <td>
        {!! Form::text('ride_from', null, ['class'=>'form-control form-filter']) !!}
    </td>
    <td>
        {!! Form::text('ride_to', null, ['class'=>'form-control form-filter']) !!}
    </td>
    <td>
        {!! Form::text('price', null, ['class'=>'form-control form-filter']) !!}
    </td>
    <td>

    </td>
    <td>
        {!!  Form::select('status', ['' => 'Select',0 => 'Inactive', 1 =>'Active'], null, ['id' => 'status-drop-down-search', 'class'=>'form-control form-filter'])!!}
    </td>
    <td>
        <button class="btn btn-sm yellow filter-submit margin-bottom-5" title="Search"><i class="fa fa-search"></i></button>
        <button class="btn btn-sm red filter-cancel margin-bottom-5" title="Reset"><i class="fa fa-times"></i></button>
    </td>
</tr>