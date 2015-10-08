<?php

/**
 * An interface to declare repository related basic functions
 * 
 * 
 * @author Nilesh G. Pangul <nileshgpangul@gmail.com>
 * @package Api
 */

namespace Modules\Api\Repositories;

interface RepositoryInterface {

    public function all($columns = array('*'));

    public function create(array $data);
}
