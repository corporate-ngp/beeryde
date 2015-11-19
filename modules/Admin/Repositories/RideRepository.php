<?php
/**
 * This class is to create user related functionalities
 *
 *
 * @author NGP <corporate.ngp@gmail.com>
 * @package Admin
 */
namespace Modules\Admin\Repositories;

use Modules\Admin\Models\Ride;
use App\Libraries\ApiResponse;
use Exception;
use Route;
use Log;
use Cache;

class RideRepository extends BaseRepository
{

    protected $ttlCache = 60; // minutes to leave Cache

    /**
     * Create a new UserRepository instance.
     *
     * @param  Modules\Admin\Models\User $user
     * @return void
     */

    public function __construct(Ride $model)
    {
        $this->model = $model;
    }

    /**
     * rules to be applied for update user params
     * @return array
     */
    public static function getUpdateRules()
    {
        return Ride::getUpdateRules();
    }

    /**
     * rules to be applied for crewate user
     * @return array
     */
    public static function getCreateRules()
    {
        return Ride::getCreateRules();
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
     * Store a Admin.
     *
     * @param  array $inputs
     * @return void
     */
    public function create($inputs)
    {

        try {
            //create user
            $inputs['password'] = (!empty($inputs['password'])) ? bcrypt($inputs['password']) : bcrypt(time());
            $model = new $this->model;
            $allColumns = $model->getTableColumns($model->getTable());
            foreach ($inputs as $key => $value) {
                if (in_array($key, $allColumns)) {
                    $model->$key = $value;
                }
            }
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
     * Update a admin.
     *
     * @param  array  $inputs
     * @param  Modules\Admin\Models\User $user
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
}
