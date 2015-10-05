<tr role="row" class="filter">
    <td></td>
    <td>
    </td>
    <td>
        {!! Form::text('location', Input::old('location'), ['class'=>'form-control form-filter']) !!}
    </td>
    <td>
        {!! Form::text('address', Input::old('address'), ['class'=>'form-control form-filter']) !!}
    </td>
    <td>
        {!!  Form::select('country_id', ['' => 'Select Country', 2 => 'India'], Input::old('country_id'), ['class'=>'select2me form-control form-filter'])!!}
    </td>
    <td>
        {!!  Form::select('state_id', ['' => 'Select State', 1 => 'Maharastra'], Input::old('state_id'), ['class'=>'select2me form-control form-filter'])!!}
    </td>
    <td>
        {!!  Form::select('city_id', ['' => 'Select City', 1 => 'Pune'], Input::old('city_id'), ['class'=>'select2me form-control form-filter'])!!}
    </td>
    <td>
        {!!  Form::select('status', ['' => 'Select',1 => 'Active', 0 =>'Inactive'], Input::old('status'), ['required', 'class'=>'select2me form-control'])!!}
    </td>
    <td>
        <button class="btn btn-sm yellow filter-submit margin-bottom-5" title="Search"><i class="fa fa-search"></i></button>
        <button class="btn btn-sm red filter-cancel margin-bottom-5" title="Reset"><i class="fa fa-times"></i></button>
    </td>
</tr>