<?php
/**
 * To present User Model with associated authentication
 * 
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api 
 */
namespace Modules\Admin\Models;

use Modules\Admin\Models\BaseModel;

class UserTokens extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'token'];

    /**
     * get user details
     * 
     * @return type
     */
    public function users()
    {
        return $this->belongsTo('Modules\Admin\Models\SiteUser', 'user_id', 'id');
    }
}
