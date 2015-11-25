<?php
/**
 * This class is to create user related functionalities
 *
 *
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api
 */
namespace Modules\Admin\Repositories;

use Modules\Admin\Models\Car as MyModel;
use Modules\Admin\Models\CarModel;
use Modules\Admin\Models\CarBrand;
use Modules\Admin\Models\SiteUser as User;
use App\Libraries\ApiResponse;
use Exception;
use Route;
use Log;
use Cache;

class CarRepository extends BaseRepository
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
        //Cache::tags($this->model->table(), CarBrand::table())->flush();
        $cacheKey = str_replace(['\\'], [''], __METHOD__) . ':' . md5(json_encode($params));
        $response = Cache::tags($this->model->table(), CarModel::table(), CarBrand::table())->remember($cacheKey, $this->ttlCache, function() {
            return MyModel::with('User', 'CarModel', 'CarBrand')->where('status',1)->orderBy('user_id', 'car_model_id', 'car_brand_id')->get();
        });

        return $response;
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
            $model = new $this->model;
            $allColumns = $model->getTableColumns($model->getTable());
            foreach ($inputs as $key => $value) {
                if (in_array($key, $allColumns)) {
                    $model->$key = $value;
                }
            }

            $carUser = User::find($inputs['user_id']);
            $model->carModel()->associate($carUser);
            
            $carModel = CarModel::find($inputs['car_model_id']);
            $model->carModel()->associate($carModel);
            
            $carBrand = CarBrand::find($inputs['car_brand_id']);
            $model->carBrand()->associate($carBrand);
            
            $model->save();
            
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
    public function update($inputs, $model)
    {
        try {
            foreach ($inputs as $key => $value) {
                if (isset($model->$key)) {
                    $model->$key = $value;
                }
            }
            $carUser = User::find($inputs['user_id']);
            $model->carModel()->associate($carUser);
            
            $carModel = CarModel::find($inputs['car_model_id']);
            $model->carModel()->associate($carModel);
            
            $carBrand = CarBrand::find($inputs['car_brand_id']);
            $model->carBrand()->associate($carBrand);
            
            $model->save();

            $response = ApiResponse::json($model);
        } catch (Exception $e) {
            $exceptionDetails = $e->getMessage();
            $response = ApiResponse::error($exceptionDetails);
            Log::error('Exception ', ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);
        }

        return $response;
    }
    
        /**
     * Store a 
     * 
     * @param  array $inputs
     * @return void
     */
    public function show($id)
    {
        $model = [];
        try {
            $model = $this->getById($id);
            
            $childTable = CarBrand::find($model->car_brand_id);
            $model->carBrand()->associate($childTable);
            
            $carUser = User::find($model->user_id);
            $model->carModel()->associate($carUser);
            
            $carModel = CarModel::find($model->car_model_id);
            $model->carModel()->associate($carModel);
            
            $carBrand = CarBrand::find($model->car_brand_id);
            $model->carBrand()->associate($carBrand);
            
        } catch (Exception $e) {
            $exceptionDetails = $e->getMessage();
            Log::error('Exception ', ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);
        }

        return $model;
    }


}
