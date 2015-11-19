<?php namespace Modules\Admin\Http\Requests;

class SiteUserUpdateRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->site_user->id;
        return [
            'email' => 'max:100|email|unique:users,email,' . $id,
            'name' => 'required|max:120',
            'password' => 'min:8|max:100|confirmed',
            'avatar' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
            'contact' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.email' => trans('admin::messages.valid-enter', ['name' => trans('admin::controller/user.email')]),
            'password.required' => trans('admin::messages.required-enter', ['name' => trans('admin::controller/user.password')]),
            'name.required' => 'Name required',
            'avatar.mimes' => trans('admin::messages.mimes'),
            'avatar.max' => trans('admin::messages.max-file-size'),
        ];
    }

    public function sanitize()
    {
        $input = $this->all();
        $input['password'] = filter_var($input['password'], FILTER_SANITIZE_STRING);
        $input['email'] = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
        $input['name'] = filter_var($input['name'], FILTER_SANITIZE_STRING);
        $input['gender'] = filter_var($input['gender'], FILTER_SANITIZE_NUMBER_INT);
        $input['contact'] = filter_var($input['contact'], FILTER_SANITIZE_STRING);

        $this->merge($input);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
