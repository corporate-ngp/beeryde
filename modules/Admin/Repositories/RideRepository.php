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
                    if (in_array($key, ['ride_from', 'ride_to', 'ride_date', 'ride_return_date', 'multiple_times_travels_dates', 'ride_preference', 'ride_purpose', 'boarding_point1', 'boarding_point2', 'boarding_point3', 'boarding_point4', 'boarding_point5', 'boarding_point6', 'boarding_point7', 'boarding_point8'])) {
                        $query->where(\DB::raw($key), 'LIKE', "%" . $value . "%");
                    }else if (in_array($key, ['from_lat_long', 'to_lat_long', 'boarding_point1_lat_long', 'boarding_point2_lat_long', 'boarding_point3_lat_long', 'boarding_point4_lat_long', 'boarding_point5_lat_long', 'boarding_point6_lat_long', 'boarding_point7_lat_long', 'boarding_point8_lat_long'])) {
                        //$query->where(\DB::raw($key), 'LIKE', "%" . $value . "%");
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
                $response['message'] = trans('admin::messages.added', ['name' => 'Ride']);
            } else {
                $response['status'] = 'error';
                $response['message'] = trans('admin::messages.not-added', ['name' => 'Ride']);
            }

            return $response;
        } catch (Exception $e) {
            $exceptionDetails = $e->getMessage();
            $response['status'] = 'error';
            $response['message'] = trans('admin::messages.not-added', ['name' => 'Ride']) . "<br /><b> Error Details</b> - " . $exceptionDetails;
            Log::error(trans('admin::messages.not-added', ['name' => 'Ride']), ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);

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
                $response['message'] = trans('admin::messages.updated', ['name' => 'Ride']);
            } else {
                $response['status'] = 'error';
                $response['message'] = trans('admin::messages.not-updated', ['name' => 'Ride']);
            }

            return $response;
        } catch (Exception $e) {

            $exceptionDetails = $e->getMessage();
            $response['status'] = 'error';
            $response['message'] = trans('admin::messages.not-updated', ['name' => 'Ride']) . "<br /><b> Error Details</b> - " . $exceptionDetails;
            Log::error(trans('admin::messages.not-updated', ['name' => 'Ride']), ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);

            return $response;
        }
    }
}
