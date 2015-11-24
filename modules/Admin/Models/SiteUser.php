<?php
/**
 * To present User Model with associated authentication
 * 
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api 
 */
namespace Modules\Admin\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\Models\BaseModel;

class SiteUser extends BaseModel implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable,
        CanResetPassword,
        SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'contact', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Serves as a "black-list" instead of a "white-list":
     * 
     *  @var array
     */
    protected $guarded = ['id'];

    /**
     * Enables soft delete to
     * 
     *  @var array
     */
    //protected $softDelete = true;
    protected $dates = ['deleted_at'];
    
    
     /**
     * Rules to validate input parameters for updating user parameters
     *
     * @var array
     */
    protected static $updateRules = array(
        'email' => 'unique:users',
        'contact' => 'unique:users',
        'facebook_id' => 'unique:users',
        'googleplus_id' => 'unique:users'
    );
    
    /**
     * Rules to validate input parameters for updating user parameters
     *
     * @var array
     */
    protected static $createRules = array(
        'email' => 'unique:users',
        'contact' => 'unique:users',
        'facebook_id' => 'unique:users',
        'googleplus_id' => 'unique:users'
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
