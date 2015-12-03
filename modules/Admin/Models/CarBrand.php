<?php
/**
 * To present User Model with associated authentication
 * 
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api 
 */
namespace Modules\Admin\Models;

use Modules\Admin\Models\BaseModel;

class CarBrand extends BaseModel 
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'car_brands';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['brand_name', 'status'];

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
        'brand_name' => 'required|exists:car_brands'
    );
    
    /**
     * Rules to validate input parameters for updating user parameters
     *
     * @var array
     */
    protected static $createRules = array(
        'brand_name' => 'required|unique:car_brands'
    );
    
    /**
     * To get the rules to validate input parameters to update user
     *
     * @return array
     */
    public static function getUpdateRules() {
        return self::$updateRules;
    }
    
    /**
     * To get the rules to validate input parameters to create user
     *
     * @return array
     */
    public static function getCreateRules() {
        return self::$createRules;
    }
}
