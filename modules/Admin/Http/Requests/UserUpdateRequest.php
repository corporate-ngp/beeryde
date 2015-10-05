<?php

namespace Modules\Admin\Http\Requests;

use Auth;

class UserUpdateRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->sanitize();
        $id = $this->user->id;
        return [
            'username' => 'min:8|max:50|unique:admins,username,' . $id,
            'email' => 'max:100|email|unique:admins,email,' . $id,
            'first_name' => 'required|max:60',
            'last_name' => 'required|max:60',
            'password' => 'min:8|max:100|confirmed',
            'gender' => 'required',
            'avatar' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
            'contact' => 'required',
            'user_type_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => trans('admin::controller/login.username-req-field'),
            'username.exists' => trans('admin::controller/login.invalid-username'),
            'email.email' => trans('admin::messages.valid-enter', ['name' => trans('admin::controller/user.email')]),
            'password.required' => trans('admin::messages.required-enter', ['name' => trans('admin::controller/user.password')]),
            'first_name.required' => trans('admin::messages.required-enter', ['name' => trans('admin::controller/user.first-name')]),
            'last_name.required' => trans('admin::messages.required-enter', ['name' => trans('admin::controller/user.first-name')]),
            'gender.required' => trans('admin::messages.required-enter', ['name' => trans('admin::controller/user.gender')]),
            'avatar.mimes' => trans('admin::messages.mimes'),
            'avatar.max' => trans('admin::messages.max-file-size'),
        ];
    }

    public function sanitize()
    {
        $input = $this->all();

        $input['password'] = filter_var($input['password'], FILTER_SANITIZE_STRING);
        $input['email'] = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
        $input['first_name'] = filter_var($input['first_name'], FILTER_SANITIZE_STRING);
        $input['last_name'] = filter_var($input['last_name'], FILTER_SANITIZE_STRING);
        $input['gender'] = filter_var($input['gender'], FILTER_SANITIZE_NUMBER_INT);
        $input['contact'] = filter_var($input['contact'], FILTER_SANITIZE_STRING);

        //Assign default value to checkbox if unchecked
        $input['skip_ip_check'] = (!empty($input['skip_ip_check'])) ? $input['skip_ip_check'] : 0;
        $input['skip_ip_check'] = filter_var($input['skip_ip_check'], FILTER_SANITIZE_NUMBER_INT);
        if (Auth::check()) {
            $input['updated_by'] = filter_var(Auth::user()->id, FILTER_SANITIZE_NUMBER_INT);
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

        $is_edit = Auth::user()->can($action['as'], 'edit');
        $own_edit = Auth::user()->can($action['as'], 'own_edit');

        if ($is_edit == 1 || (!empty($own_edit) && ($this->user->created_by == Auth::user()->id))) {
            return true;
        } else {
            abort(403);
        }
    }
}
