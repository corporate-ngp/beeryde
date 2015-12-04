<?php
/**
 * This class is to create user related functionalities
 *
 *
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api
 */
namespace Modules\Admin\Repositories;

use Modules\Admin\Models\CarBrand as MyModel;
use App\Libraries\ApiResponse;
use Exception;
use Route;
use Log;
use Cache;

class CarBrandRepository extends BaseRepository
{

    protected $ttlCache = 60; // minutes to leave Cache

    /**
     * Create a new Repository instance.
     *
     * @param  $model
     * @return void
     */

    public function __construct(MyModel $model)
    {
        $this->model = $model;
    }

    /**
     * rules to be applied for update user params
     * @return array
     */
    public static function getUpdateRules()
    {
        return MyModel::getUpdateRules();
    }

    /**
     * rules to be applied for crewate user
     * @return array
     */
    public static function getCreateRules()
    {
        return MyModel::getCreateRules();
    }

    /**
     * Admin users listing
     *
     * @param  array  $params
     * @return Response
     */
    public function data($params = [])
    {
        //Cache::tags($this->model->table())->flush();
        $cacheKey = str_replace(['\\'], [''], __METHOD__) . ':' . md5(json_encode($params));
        $response = Cache::tags($this->model->table())->remember($cacheKey, $this->ttlCache, function() {
            return $this->model->select('*')->get();
        });

        return $response;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function listCarBrandData()
    {
        $cacheKey = str_replace(['\\'], [''], __METHOD__);
        //Cache::tags not suppport with files and Database
        $response = Cache::tags($this->model->table())->remember($cacheKey, $this->ttlCache, function() {
            return $this->model->orderBY('id')->lists('brand_name', 'id');
        });

        return $response;
    }
    

    /**
     * Save the Model data.
     *
     * @param  Array  $inputs
     * @return void
     */
    private function save($inputs, $model = '')
    {
        if (empty($model)) {
            $model = new $this->model;
            $allColumns = $model->getTableColumns($model->getTable());
            foreach ($inputs as $key => $value) {
                if (in_array($key, $allColumns)) {
                    $model->$key = $value;
                }
            }
        } else {
            foreach ($inputs as $key => $value) {
                if (isset($model->$key) && $value != "") {
                    $model->$key = $value;
                }
            }
        }

        $model->save();

        return $model;
    }

    /**
     * Store a 
     * 
     * @param  array $inputs
     * @return void
     */
    public function create($inputs)
    {
        try {
            $model = $this->save($inputs);
            $response = ApiResponse::json($model);
        } catch (Exception $e) {
            $exceptionDetails = $e->getMessage();
            $response = ApiResponse::error($exceptionDetails);
            Log::error('Exception ', ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);
        }

        return $response;
    }

    /**
     * Update a record.
     *
     * @param  array  $inputs
     * @return void
     */
    public function update($inputs, $modelObj)
    {
        try {
            foreach ($inputs as $key => $value) {
                if (isset($modelObj->$key)) {
                    $modelObj->$key = $value;
                }
            }
            $modelObj->save();

            $response = ApiResponse::json($modelObj);
        } catch (Exception $e) {
            $exceptionDetails = $e->getMessage();
            $response = ApiResponse::error($exceptionDetails);
            Log::error('Exception ', ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);
        }

        return $response;
    }
    
     /**
     * Store a newly created resource in storage.
     *
     * @param  Form data posted from ajax $inputs
     * @return $result array with status and message elements
     */
    public function store($inputs)
    {
        try {
            $model = new $this->model;
            $allColumns = $model->getTableColumns($model->getTable());
            foreach ($inputs as $key => $value) {
                if (in_array($key, $allColumns)) {
                    $model->$key = $value;
                }
            }

            $save = $model->save();

            if ($save) {
                $response['status'] = 'success';
                $response['message'] = trans('admin::messages.added', ['name' => 'Car Brand']);
            } else {
                $response['status'] = 'error';
                $response['message'] = trans('admin::messages.not-added', ['name' => 'Car Brand']);
            }

            return $response;
        } catch (Exception $e) {
            $exceptionDetails = $e->getMessage();
            $response['status'] = 'error';
            $response['message'] = trans('admin::messages.not-added', ['name' => 'Car Brand']) . "<br /><b> Error Details</b> - " . $exceptionDetails;
            Log::error(trans('admin::messages.not-added', ['name' => 'Car Brand']), ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);

            return $response;
        }
    }

    /**
     * Update a country.
     *
     * @param  Form data posted from ajax $inputs, Modules\Admin\Models\Country $model
     * @return $result array with status and message elements
     */
    public function updateMe($inputs, $model)
    {
        try {

            foreach ($inputs as $key => $value) {
                if (isset($model->$key)) {
                    $model->$key = $value;
                }
            }

            $save = $model->save();

            if ($save) {
                $response['status'] = 'success';
                $response['message'] = trans('admin::messages.updated', ['name' => 'Car Brand']);
            } else {
                $response['status'] = 'error';
                $response['message'] = trans('admin::messages.not-updated', ['name' => 'Car Brand']);
            }

            return $response;
        } catch (Exception $e) {

            $exceptionDetails = $e->getMessage();
            $response['status'] = 'error';
            $response['message'] = trans('admin::messages.not-updated', ['name' => 'Car Brand']) . "<br /><b> Error Details</b> - " . $exceptionDetails;
            Log::error(trans('admin::messages.not-updated', ['name' => 'Car Brand']), ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);

            return $response;
        }
    }
    


}
