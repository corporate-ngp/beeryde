<?php

/**
 * An interface to declare repository related basic functions
 * 
 * 
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api
 */

namespace Modules\Api\Repositories;

interface RepositoryInterface {

    public function all($columns = array('*'));

    public function create(array $data);
}
