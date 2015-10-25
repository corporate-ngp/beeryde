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

class SystemEmailUpdateRequest extends Request
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
            'name' => 'required|alphaDash|max:255|unique:system_emails,name,' . $this->system_emails->id,
            'description' => 'required|max:255',
            'email_to' => 'email_multi',
            'email_cc' => 'email_multi',
            'email_bcc' => 'email_multi',
            'email_from' => 'addr_spec_email|max:100',
            'subject' => 'required|max:255',
            'email_type' => 'required|numeric',
            'status' => 'required|numeric'
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
            $input['updated_by'] = filter_var(Auth::user()->id, FILTER_SANITIZE_NUMBER_INT);
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

        $is_edit = Auth::user()->can($action['as'], 'edit');
        $own_edit = Auth::user()->can($action['as'], 'own_edit');

        if ($is_edit == 1 || (!empty($own_edit) && ($this->system_emails->created_by == Auth::user()->id))) {
            return true;
        } else {
            abort(403);
        }
    }
}
