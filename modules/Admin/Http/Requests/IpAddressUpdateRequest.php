<?php
/**
 * The class for handling validation requests
 * 
 * 
 * @author NGP <corporate.ngp@gmail.com>

 
 */

namespace Modules\Admin\Http\Requests;

use Modules\Admin\Http\Requests\Request;
use Auth;

class IpAddressUpdateRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->sanitize();

        return $rules = [
            'ip_address' => 'required|ip|unique:ip_addresses,ip_address,' . $this->ipaddress->id,
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'ip_address.required' => 'Please enter IP Address.',
            'ip_address.ip' => 'Please enter valid IP Address.',
            'status.required' => 'Please select Status.'
        ];
    }

    /**
     * Sanitize all input fieds and replace
     */
    public function sanitize()
    {
        $input = $this->all();

        $input['ip_address'] = filter_var($input['ip_address'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        $input['status'] = filter_var($input['status'], FILTER_SANITIZE_NUMBER_INT);
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

        if ($is_edit == 1 || (!empty($own_edit) && ($this->ipaddress->created_by == Auth::user()->id))) {
            return true;
        } else {
            abort(403);
        }
    }
}
