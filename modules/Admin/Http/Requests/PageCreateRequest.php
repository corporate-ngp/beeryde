<?php
/**
 *  
 * @author Nilesh G. Pangul <nileshgpangul@gmail.com>
 * @package Admin
 * @since 1.0
 */

namespace Modules\Admin\Http\Requests;

use Modules\Admin\Http\Requests\Request,
    HTML,
    Auth;

class PageCreateRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->sanitize();
        return [
            'page_name' => 'required|min:2|unique:site_pages',
            'slug' => 'required|min:2|unique:site_pages',
            'page_url' => 'required|unique:site_pages',
            'browser_title' => 'required|min:2',
            'meta_keywords' => 'required|min:2',
            'meta_description' => 'required|min:5',
            'page_content' => 'required',
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'slug.unique' => trans('admin::controller/page.slug-exists'),
            'page_name.min' => trans('admin::controller/page.page_name-min'),
            'browser_title.min' => trans('admin::controller/page.browser_title.min'),
            'meta_keywords.min' => trans('admin::controller/page.meta_keywords.min'),
            'meta_description.min' => trans('admin::controller/page.meta_description.min'),
            'slug.min' => trans('admin::controller/page.slug.min'),
            'page_content.required' => trans('admin::controller/page.page_content.required')
        ];
    }

    /**
     * Sanitize all input fieds and replace
     */
    public function sanitize()
    {
        $input = $this->all();

        $input['page_name'] = filter_var($input['page_name'], FILTER_SANITIZE_STRING);
        $input['slug'] = filter_var($input['slug'], FILTER_SANITIZE_STRING);
        $input['page_url'] = filter_var($input['page_url'], FILTER_SANITIZE_STRING);
        $input['browser_title'] = filter_var($input['browser_title'], FILTER_SANITIZE_STRING);
        $input['meta_keywords'] = filter_var($input['meta_keywords'], FILTER_SANITIZE_STRING);
        $input['meta_description'] = filter_var($input['meta_description'], FILTER_SANITIZE_STRING);
        $input['page_desc'] = HTML::entities($input['page_desc']);
        $input['page_content'] = HTML::entities($input['page_content']);
        $input['status'] = filter_var($input['status'], FILTER_SANITIZE_NUMBER_INT);

        if (Auth::check()) {
            $input['created_by'] = filter_var(Auth::user()->id, FILTER_SANITIZE_NUMBER_INT);
        }
        $this->merge($input);
    }

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
}
