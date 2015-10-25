<?php
/**
 * The class for handling validation requests from SystemEmailController::store()
 * 
 * 
 * @author NGP <corporate.ngp@gmail.com>

 
 */

namespace Modules\Admin\Http\Requests;

use Modules\Admin\Http\Requests\Request;
use Auth;
use HTML;

class SystemEmailCreateRequest extends Request
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
            'name' => 'required|alphaDash|max:255|unique:system_emails',
            'description' => 'required|max:255',
            'email_to' => 'email_multi',
            'email_cc' => 'email_multi',
            'email_bcc' => 'email_multi',
            'email_from' => 'addr_spec_email|max:100',
            'subject' => 'required|max:255',
            'email_type' => 'required|numeric',
            'status' => 'numeric'
        ];
    }

    /**
     * Sanitize all input fieds and replace
     */
    public function sanitize()
    {
        $input = $this->all();

        $input['name'] = filter_var($input['name'], FILTER_SANITIZE_STRING);
        $input['description'] = filter_var($input['description'], FILTER_SANITIZE_STRING);
        $input['subject'] = filter_var($input['subject'], FILTER_SANITIZE_STRING);
        $input['email_type'] = filter_var($input['email_type'], FILTER_SANITIZE_NUMBER_INT);
        if (Auth::check()) {
            $input['created_by'] = filter_var(Auth::user()->id, FILTER_SANITIZE_NUMBER_INT);
        }
        $input['text1'] = HTML::entities($input['text1']);
        $input['text2'] = HTML::entities($input['text2']);
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
