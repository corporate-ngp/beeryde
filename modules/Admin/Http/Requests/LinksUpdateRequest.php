<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Support\Facades\Auth;

class LinksUpdateRequest extends Request
{

    public function authorize()
    {
        $action = $this->route()->getAction();

        $is_edit = Auth::user()->can($action['as'], 'edit');
        $own_edit = Auth::user()->can($action['as'], 'own_edit');

        if ($is_edit == 1 || (!empty($own_edit) && ($this->links->created_by == Auth::user()->id))) {
            return true;
        } else {
            abort(403);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->sanitize();
        $id = $this->links->id;

        return $rules = [
            'link_name' => 'required|min:2|max:50|unique:links,link_name,' . $id,
            'link_url' => 'required|min:2|max:50|link_route|unique:links,link_url,' . $id,
            'page_header' => 'required|min:2|max:50|unique:links,page_header,' . $id,
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
            $input['updated_by'] = filter_var(Auth::user()->id, FILTER_SANITIZE_NUMBER_INT);
        }
        $this->merge($input);
    }
}
