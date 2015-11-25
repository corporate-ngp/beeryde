<?php
/**
 * To present User Model with associated authentication
 * 
 * @author NGP <corporate.ngp@gmail.com>
 * @package Admin
 */
namespace Modules\Admin\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\Models\BaseModel;

class Ride extends BaseModel
{

    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rides';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'ride_from', 'ride_to', 'price', 'status'];

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
        'user_id' => 'required',
        'ride_from' => 'required',
        'ride_to' => 'required',
        'price' => 'required'
    );
    
    /**
     * Rules to validate input parameters for updating user parameters
     *
     * @var array
     */
    protected static $createRules = array(
        'user_id' => 'required',
        'ride_from' => 'required',
        'ride_to' => 'required',
        'price' => 'required'
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
    
    /**
     * get user details
     * function name is used as it while joining with child table
     * @return type
     */
    public function car()
    {
        return $this->belongsTo('Modules\Admin\Models\Car', 'car_id', 'id');
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
