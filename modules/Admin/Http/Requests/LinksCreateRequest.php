<?php

namespace Modules\Admin\Http\Requests;

use Modules\Admin\Http\Requests\Request,
    Illuminate\Support\Facades\Auth;

class LinksCreateRequest extends Request
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
            'link_name' => 'required|min:2|max:50|unique:links',
            'link_url' => 'required|min:2|max:50|link_route|unique:links',
            'page_header' => 'required|min:2|max:50|unique:links',
            'link_category_id' => 'required|integer',
            'position' => 'required|integer',
            'link_icon' => 'required',
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'position.unique' => trans('admin::controller/links.position-unique'),
            'link_name.unique' => trans('admin::controller/links.linkname-unique'),
            'link_url.unique' => trans('admin::controller/links.linkurl-unique'),
            'page_header.unique' => trans('admin::controller/links.pageheader-unique'),
            'link_url.min' => trans('admin::controller/links.link_url.min'),
            'link_name.min' => trans('admin::controller/links.link_name.min'),
            'page_header.min' => trans('admin::controller/links.page_header.min')
        ];
    }

    public function sanitize()
    {
        $input = $this->all();

        $input['link_name'] = filter_var($input['link_name'], FILTER_SANITIZE_STRING);
        $input['link_url'] = filter_var($input['link_url'], FILTER_SANITIZE_STRING);
        $input['page_header'] = filter_var($input['page_header'], FILTER_SANITIZE_STRING);
        $input['page_text'] = filter_var($input['page_text'], FILTER_SANITIZE_STRING);
        $input['link_icon'] = filter_var($input['link_icon'], FILTER_SANITIZE_STRING);
        $input['position'] = filter_var($input['position'], FILTER_SANITIZE_NUMBER_INT);
        $input['link_category_id'] = filter_var($input['link_category_id'], FILTER_SANITIZE_NUMBER_INT);

        if (Auth::check()) {
            $input['created_by'] = filter_var(Auth::user()->id, FILTER_SANITIZE_NUMBER_INT);
        }
        $this->merge($input);
    }
}
