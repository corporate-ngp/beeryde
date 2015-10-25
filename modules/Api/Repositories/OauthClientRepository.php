<?php

/**
 * This class is to create OauthClient related functionalities
 * 
 * 
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api
 */

namespace Modules\Api\Repositories;

use \App\Libraries\ApiResponse as ApiResponse;
use \Modules\Api\Models\OauthClient as OauthClient;
use Input;

class OauthClientRepository extends BaseRepository {
    
    /**
     * Create a new OauthClientRepository instance.
     *
     * @param  Modules\Api\Models\OauthClients $oauthClient
     * @return void
     * 
     */
    public function __construct(OauthClient $oauthClient) {
        $this->model = $oauthClient;
    }

}
