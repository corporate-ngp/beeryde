<?php
/**
 * To present User Model with associated authentication
 * 
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api 
 */
namespace Modules\Admin\Models;

use Modules\Admin\Models\BaseModel;

class CarModel extends BaseModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'car_models';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['model_name', 'car_brand_id', 'status'];

    /**
     * Serves as a "black-list" instead of a "white-list":
     * 
     *  @var array
     */
    protected $guarded = ['id'];

    /**
     * Rules to validate input parameters for updating user parameters
     *
     * @var array
     */
    protected static $updateRules = array(
        'model_name' => 'unique:car_models',
        'car_brand_id' => 'required'
    );

    /**
     * Rules to validate input parameters for updating user parameters
     *
     * @var array
     */
    protected static $createRules = array(
        'model_name' => 'required|unique:car_models',
        'car_brand_id' => 'required'
    );

    /**
     * To get the rules to validate input parameters to update user
     *
     * @return array
     */
    public static function getUpdateRules()
    {
        return self::$updateRules;
    }

    /**
     * To get the rules to validate input parameters to create user
     *
     * @return array
     */
    public static function getCreateRules()
    {
        return self::$createRules;
    }

    /**
     * get user details
     * 
     * @return type
     */
    public function carBrands()
    {
        return $this->belongsTo('Modules\Admin\Models\CarBrand', 'car_brand_id', 'id');
    }
}
