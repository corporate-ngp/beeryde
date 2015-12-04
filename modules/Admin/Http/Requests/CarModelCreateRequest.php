<?php
/**
 * The class for handling validation requests from store()
 * 
 * 
 * @author NGP <corporate.ngp@gmail.com>

 
 */
namespace Modules\Admin\Http\Requests;

use Modules\Admin\Http\Requests\Request;
use Auth;

class CarModelCreateRequest extends Request
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
            'model_name' => 'required|unique:car_models',
            'car_brand_id' => 'required'
        ];
    }

    /**
     * Sanitize all input fieds and replace
     */
    public function sanitize()
    {
        $input = $this->all();

        $input['car_brand_id'] = filter_var($input['car_brand_id'], FILTER_SANITIZE_NUMBER_INT);
        $input['model_name'] = filter_var($input['model_name'], FILTER_SANITIZE_STRING);
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
