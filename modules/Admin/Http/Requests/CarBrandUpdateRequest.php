<?php
/**
 * The class for handling validation requests from CountryController::update()
 * 
 * 
 * @author NGP <corporate.ngp@gmail.com>


 */
namespace Modules\Admin\Http\Requests;

use Modules\Admin\Http\Requests\Request;
use Auth;

class CarBrandUpdateRequest extends Request
{

    public function rules()
    {
        $this->sanitize();
        return [
            'brand_name' => 'required|max:150|unique:car_brands,brand_name,' . $this->car_brands->id,
            'status' => 'required|numeric'
        ];
    }

    /**
     * Sanitize all input fieds and replace
     */
    public function sanitize()
    {
        $input = $this->all();
        $input['brand_name'] = filter_var($input['brand_name'], FILTER_SANITIZE_STRING);
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
