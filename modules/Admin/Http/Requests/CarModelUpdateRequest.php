<?php
/**
 * The class for handling validation requests from ConfigSettingController::update()
 * 
 * 
 * @author NGP <corporate.ngp@gmail.com>

 
 */
namespace Modules\Admin\Http\Requests;

use Modules\Admin\Http\Requests\Request;
use Auth;

class CarModelUpdateRequest extends Request
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
            'name' => 'required|unique:states,name,' . $this->states->id,
            'country_id' => 'required',
            'state_code' => 'required|unique:states,state_code,' . $this->states->id
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'State Name already taken.',
            'state_code.unique' => 'State Code already taken.'
        ];
    }

    /**
     * Sanitize all input fieds and replace
     */
    public function sanitize()
    {
        $input = $this->all();

        $input['country_id'] = filter_var($input['country_id'], FILTER_SANITIZE_NUMBER_INT);
        $input['name'] = filter_var($input['name'], FILTER_SANITIZE_STRING);
        $input['state_code'] = filter_var($input['state_code'], FILTER_SANITIZE_STRING);
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

        if ($is_edit == 1 || (!empty($own_edit) && ($this->states->created_by == Auth::user()->id))) {
            return true;
        } else {
            abort(403);
        }
    }
}
