<?php

/**
 * This class is to create rating related functionalities
 * 
 * 
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api
 */

namespace Modules\Api\Repositories;

use \Modules\Api\Models\Rating as Rating;
use App\Libraries\ApiResponse;
use Cache;
use DB;

class RatingRepository extends BaseRepository {

    /**
     * Create a new RatingRepository instance.
     *
     * @param  Modules\Api\Models\Rating $rating
     * @return void
     */
    public function __construct(Rating $rating) {
        $this->model = $rating;
    }
}    