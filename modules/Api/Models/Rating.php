<?php

/**
 * To present Rating Model with associated authentication
 *
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api
 */

namespace Modules\Api\Models;

use Modules\Api\Models\BaseModel;

class Rating extends BaseModel {

    public $timestamps = false;

    /**
     * The database collection used by the model.
     *
     * @var string
     */
    protected $collection = 'ratings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('group_code', 'ratings_by', 'ratings_to', 'ratings');
    
    /**
     * used to join with Modules\Admin\Models\User
     * 
     * @return user
     */
    public function givenByUser() {
        return $this->belongsTo('\Modules\Api\Models\User', 'ratings_by');
    }
    
    /**
     * used to join with Modules\Admin\Models\User
     * 
     * @return user
     */
    public function givenToUser() {
        return $this->belongsTo('\Modules\Api\Models\User', 'ratings_to');
    }
}
