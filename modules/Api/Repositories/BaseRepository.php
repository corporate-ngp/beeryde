<?php

/**
 * @abstract class for creating base for all repositories 
 * 
 * 
 * @author Nilesh G. Pangul <nileshgpangul@gmail.com>
 * @package Api
 */

namespace Modules\Api\Repositories;

abstract class BaseRepository {

    /**
     * The Model instance.
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;
    protected $ttlCache = 3600; // 60 minutes * 6 = 6 hours

    /**
     * Get all records.
     *
     * @return array
     */

    public function all($columns = array('*')) {
        return $this->model->get($columns)->toArray();
    }

    /**
     * create new record.
     *
     * @return array
     */
    public function create(array $data) {
        return $this->model->create($data)->toArray();
    }

    /**
     * Get number of records.
     *
     * @return array
     */
    public function getNumber() {
        $total = $this->model->count();

        $new = $this->model->whereSeen(0)->count();

        return compact('total', 'new');
    }

    /**
     * Destroy a model.
     *
     * @param  int $id
     * @return void
     */
    public function destroy($id) {
        $this->getById($id)->delete();
    }

    /**
     * Get Model by id.
     *
     * @param  int  $id
     * @return App\Models\Model
     */
    public function getById($id) {
        return $this->model->findOrFail($id)->toArray();
    }
    
    /**
     * find model by id.
     *
     * @param  int  $id
     * @return App\Models\Model
     */
    public function find($id) {
        return $this->model->findOrFail($id);
    }

}
