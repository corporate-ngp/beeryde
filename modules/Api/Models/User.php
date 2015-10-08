<?php

/**
 * To present User Model with associated authentication
 * 
 * @author Nilesh G. Pangul <nileshgpangul@gmail.com>
 * @package Api 
 */

namespace Modules\Api\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Api\Models\BaseModel;

class User extends BaseModel {
    
    /**
     * 	Force Eloquent to use user_id as PK and not id
     */
    protected $primaryKey = 'user_id';

    /**
     * The database collection used by the model.
     *
     * @var string
     */
    protected $collection = 'users';
   
    /**
     * Enable soft deletes
     * 
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $softDelete = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'country_code', 'phone', 'name', 'is_active', 'is_login'];

    /**
     * Rules to validate input parameters for updating user parameters
     *
     * @var array
     */
    protected static $updateRules = array(
        'phone' => 'required|exists:users'
    );
    
    /**
     * Rules to validate input parameters for updating phone parameters
     *
     * @var array
     */
    protected static $updatePhoneRules = array(
        'new_country_code' => 'required|numeric',
        'new_phone' => 'required|numeric',
        'old_country_code' => 'required|numeric|exists:users,country_code',
        'old_phone' => 'required|numeric|exists:users,phone',
        'otp' => 'required'
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
     * To get the rules to validate input parameters to update user
     *
     * @return array
     */
    public static function getUpdatePhoneRules() {
        return self::$updatePhoneRules;
    }

    /**
     * get details of travel from Travel model when used in join
     * @return array
     */
    public function travel() {
        return $this->hasMany('\Modules\Api\Models\Travel', 'user_id');
    }    
}
