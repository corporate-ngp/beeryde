<?php
/**
 * The class for handling validation requests from CityController::update()
 * 
 * 
 * @author NGP <corporate.ngp@gmail.com>

 
 */

namespace Modules\Admin\Http\Requests;

use Modules\Admin\Http\Requests\Request;
use Auth;

class CarUpdateRequest extends Request
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
            'car_model_id' => 'required|numeric',
            'car_brand_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'status' => 'required|numeric'
        ];
    }

    /**
     * Sanitize all input fieds and replace
     */
    public function sanitize()
    {
        $input = $this->all();

        $input['car_model_id'] = filter_var($input['car_model_id'], FILTER_SANITIZE_NUMBER_INT);
        $input['car_brand_id'] = filter_var($input['car_brand_id'], FILTER_SANITIZE_NUMBER_INT);
        $input['user_id'] = filter_var($input['user_id'], FILTER_SANITIZE_STRING);
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

        if ($is_edit == 1 || (!empty($own_edit))) {
            return true;
        } else {
            abort(403);
        }
    }
}
