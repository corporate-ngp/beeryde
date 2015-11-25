<?php
/**
 * To present User Model with associated authentication
 * 
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api 
 */
namespace Modules\Admin\Models;

use Modules\Admin\Models\BaseModel;

class Car extends BaseModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cars';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'car_model_id', 'car_brand_id', 'color', 'comfort', 'seats', 'registration_number', 'status'];

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
        'user_id' => 'required',
        'car_brand_id' => 'required',
        'car_model_id' => 'required',
        'color' => 'required',
        'comfort' => 'required',
        'seats' => 'required',
        'registration_number' => 'required'
    );

    /**
     * Rules to validate input parameters for updating user parameters
     *
     * @var array
     */
    protected static $createRules = array(
        'user_id' => 'required',
        'car_brand_id' => 'required',
        'car_model_id' => 'required',
        'color' => 'required',
        'comfort' => 'required',
        'seats' => 'required',
        'registration_number' => 'required'
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
     * function name is used as it while joining with child table
     * @return type
     */
    public function carBrand()
    {
        return $this->belongsTo('Modules\Admin\Models\CarBrand', 'car_brand_id', 'id');
    }
    
    /**
     * get user details
     * function name is used as it while joining with child table
     * @return type
     */
    public function carModel()
    {
        return $this->belongsTo('Modules\Admin\Models\CarModel', 'car_model_id', 'id');
    }
    
    /**
     * get user details
     * function name is used as it while joining with child table
     * @return type
     */
    public function user()
    {
        return $this->belongsTo('Modules\Admin\Models\SiteUser', 'user_id', 'id');
    }
}
