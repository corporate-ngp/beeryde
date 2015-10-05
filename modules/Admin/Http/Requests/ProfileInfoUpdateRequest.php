<?php

namespace Modules\Admin\Http\Requests;

class ProfileInfoUpdateRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->sanitize();

        $id = $this->myprofile->id;

        return [
            'email' => 'max:100|email|unique:admins,email,' . $id,
            'first_name' => 'required|alpha|max:60',
            'last_name' => 'required|alpha|max:60',
            'password' => 'min:8|max:100|confirmed',
            'gender' => 'required',
            'contact' => 'required|numeric|digits:10',
            'user_type_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.email' => trans('admin::messages.valid-enter', ['name' => trans('admin::controller/user.email')]),
            'first_name.required' => trans('admin::messages.required-enter', ['name' => trans('admin::controller/user.first-name')]),
            'last_name.required' => trans('admin::messages.required-enter', ['name' => trans('admin::controller/user.first-name')]),
            'gender.required' => trans('admin::messages.required-enter', ['name' => trans('admin::controller/user.gender')]),
            'contact.digits' => 'The Mobile Number must contain 10 characters.',
        ];
    }

    public function sanitize()
    {
        $input = $this->all();

        $input['email'] = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
        $input['first_name'] = filter_var($input['first_name'], FILTER_SANITIZE_STRING);
        $input['last_name'] = filter_var($input['last_name'], FILTER_SANITIZE_STRING);
        $input['gender'] = filter_var($input['gender'], FILTER_SANITIZE_NUMBER_INT);
        $input['contact'] = filter_var($input['contact'], FILTER_SANITIZE_STRING);
        $input['user_type_id'] = filter_var($input['gender'], FILTER_SANITIZE_NUMBER_INT);

        $this->replace($input);
    }
}
