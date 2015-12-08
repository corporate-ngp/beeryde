<?php
/**
 * This class is to create user related functionalities
 *
 *
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api
 */
namespace Modules\Admin\Repositories;

use Modules\Admin\Models\Ride as MyModel;
use Modules\Admin\Models\Car;
use Modules\Admin\Models\SiteUser as User;
use App\Libraries\ApiResponse;
use Exception;
use Route;
use Log;
use Cache;
use DB;

class RideRepository extends BaseRepository
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
        //Cache::tags($this->model->table(), Car::table(), User::table())->flush();
        $cacheKey = str_replace(['\\'], [''], __METHOD__) . ':' . md5(json_encode($params));
        $response = Cache::tags($this->model->table(), Car::table(), User::table())->remember($cacheKey, $this->ttlCache, function() use ($params) {
            //return MyModel::with('User', 'Car')->where('status', 1)->orderBy('user_id', 'car_id')->get();
            $query = MyModel::with('User', 'Car');

            $model = new $this->model;
            $allColumns = $model->getTableColumns($model->getTable());
            foreach ($params as $key => $value) {

                if (in_array($key, $allColumns)) {
                    if (in_array($key, ['ride_from', 'ride_to'])) {
                        $query->where(DB::raw($key), 'LIKE', "%" . $value . "%");
                    } else {
                        $query->where($key, '=', $value);
                    }
                }
            }

            $query->orderBy('user_id', 'car_id');
            //dd($query->getQuery()->toSql());
            return $query->get();
            
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
            $model->user()->associate($carUser);

            $carModel = Car::find($inputs['car_id']);
            $model->car()->associate($carModel);

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
            $model->user()->associate($carUser);

            $carModel = Car::find($inputs['car_id']);
            $model->car()->associate($carModel);

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

            $carUser = User::find($model->user_id);
            $model->user()->associate($carUser);

            $carModel = Car::find($model->car_model_id);
            $model->car()->associate($carModel);
        } catch (Exception $e) {
            $exceptionDetails = $e->getMessage();
            Log::error('Exception ', ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);
        }

        return $model;
    }
}
