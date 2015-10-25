<?php

/**
 * To present Token Model with associated authentication
 * 
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api 
 */

namespace Modules\Api\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Api\Models\BaseModel;

class Token extends BaseModel {
    
    /**
     * 	Force Eloquent to use token_id as PK and not id
     */
    protected $primaryKey = 'token_id';
    
    /**
     * The database collection used by the model.
     *
     * @var string
     */
    protected $collection = 'tokens';
    
    /**
     * Serves as a "black-list" instead of a "white-list":
     * 
     *  @var array
     */
    protected $guarded = array('key');
    
    /**
     * Rules to validate input parameters to get token
     *
     * @var array
     */
    protected static $tokenRules = array(
        'token' => 'required'
    );
    
    /**
     * To get rules to validate input parameters for retrieving existing token
     *
     * @var array
     */
    public static function getTokenRules() {
        return self::$tokenRules;
    }

}
