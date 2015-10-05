<?php

namespace Modules\Admin\Http\Requests;

use Modules\Admin\Http\Requests\Request,
    Illuminate\Support\Facades\Auth;

class LinkCategoryCreateRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $action = $this->route()->getAction();

        $status = Auth::user()->can($action['as'], 'store');
        if (empty($status)) {
            abort(403);
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->sanitize();

        return [
            'category' => 'required|min:2|max:50|unique:link_categories',
            'header_text' => 'min:5|max:255|required',
            'position' => 'required|integer|unique:link_categories',
            'category_icon' => 'required',
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'position.unique' => trans('admin::controller/linkcategory.position-exists'),
            'category.unique' => trans('admin::controller/linkcategory.category-exists'),
            'category.min' => trans('admin::controller/linkcategory.category-min'),
            'header_text.min' => trans('admin::controller/linkcategory.headertext.min')
        ];
    }

    public function sanitize()
    {
        $input = $this->all();

        $input['category'] = filter_var($input['category'], FILTER_SANITIZE_STRING);
        $input['header_text'] = filter_var($input['header_text'], FILTER_SANITIZE_STRING);
        $input['category_icon'] = filter_var($input['category_icon'], FILTER_SANITIZE_STRING);
        $input['position'] = filter_var($input['position'], FILTER_SANITIZE_NUMBER_INT);

        if (Auth::check()) {
            $input['created_by'] = filter_var(Auth::user()->id, FILTER_SANITIZE_NUMBER_INT);
        }
        $this->merge($input);
    }
}
