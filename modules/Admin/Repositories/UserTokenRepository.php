<?php
/**
 * The repository class for managing faq specific actions.
 * 
 * 
 * @author NGP <corporate.ngp@gmail.com>


 */
namespace Modules\Admin\Repositories;

use Modules\Admin\Models\UserTokens;
use Modules\Admin\Models\SiteUser;
use App\Libraries\ApiResponse;
use Exception;
use Route;
use Log;
use Cache;
use Request;

class UserTokenRepository extends BaseRepository
{

    /**
     * Create a new FaqRepository instance.
     *
     * @param  Modules\Admin\Models\Faq $model
     * @return void
     */
    public function __construct(UserTokens $model)
    {
        $this->model = $model;
    }

    /**
     * Get a listing of the resource.
     *
     * @return Response
     */
    public function userToken($params = [])
    {
        $cacheKey = str_replace(['\\'], [''], __METHOD__) . ':' . md5(json_encode($params));
        $response = Cache::tags($this->model->table())->remember($cacheKey, $this->ttlCache, function() use ($params) {
            $dataObj = $this->model->where('user_id', $params['user_id'])->orderBy('created_at')->first();
            if (!empty($dataObj)) {
                $data = $dataObj->toArray();
                return $data['token'];
            }
        });

        return $response;
    }
    
    /**
     * Get a listing of the resource.
     *
     * @return Response
     */
    public function token($token)
    {           
        $cacheKey = str_replace(['\\'], [''], __METHOD__) . ':' . md5($token);
        $response = Cache::tags($this->model->table())->remember($cacheKey, $this->ttlCache, function() use ($token) {
            $dataObj = $this->model->where('token', $token)->first();
            if (!empty($dataObj)) {
                return true;
            }
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
            $dataObj = new $this->model;
            $allColumns = $dataObj->getTableColumns($dataObj->getTable());
            foreach ($inputs as $key => $value) {
                if (in_array($key, $allColumns)) {
                    $dataObj->$key = $value;
                }
            }
            //delete users old tokens
            $this->detachTokens($inputs);
            
            //link user token to users
            $siteUserRepository = new SiteUserRepository(new SiteUser);
            $user = $siteUserRepository->getByIdWithTrashed($inputs['user_id']);
            $dataObj->users()->associate($user);
            
            //save the data and return response
            $dataObj->save();
            $response = ApiResponse::json($dataObj);
            
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
    public function detachTokens($inputs)
    {
        $this->model->where('user_id', $inputs['user_id'])->delete();
    }
    
    public function detroyToken()
    {
        if (!empty(Request::header('Ryde-Token'))) {
            $this->model->where('token', Request::header('Ryde-Token'))->delete();
        }
    }
}
