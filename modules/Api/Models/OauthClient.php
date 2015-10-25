<?php

/**
 * To present OauthClient Model 
 *
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api
 */

namespace Modules\Api\Models;

use Modules\Api\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class OauthClient extends BaseModel {

    /**
     * The database collection used by the model.
     *
     * @var string
     */
    protected $collection = 'oauth_clients';

}
