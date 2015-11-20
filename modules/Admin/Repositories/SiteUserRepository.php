<?php
/**
 * This class is to create user related functionalities
 *
 *
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api
 */
namespace Modules\Admin\Repositories;

use Modules\Admin\Models\SiteUser;
use Modules\Admin\Services\Helper\ImageHelper;
use App\Libraries\ApiResponse;
use Exception;
use Route;
use Log;
use Cache;
use URL;
use File;

class SiteUserRepository extends BaseRepository
{

    protected $ttlCache = 60; // minutes to leave Cache

    /**
     * Create a new UserRepository instance.
     *
     * @param  Modules\Admin\Models\User $user
     * @return void
     */

    public function __construct(SiteUser $user)
    {
        $this->model = $user;
    }

    /**
     * rules to be applied for update user params
     * @return array
     */
    public static function getUpdateRules()
    {
        return SiteUser::getUpdateRules();
    }

    /**
     * rules to be applied for crewate user
     * @return array
     */
    public static function getCreateRules()
    {
        return SiteUser::getCreateRules();
    }

    /**
     * Group actions on Users
     *
     * @param  int  $status
     * @return int
     */
    public function groupAction($inputs)
    {
        if (empty($inputs['action'])) {
            return ['status' => 'fail', 'message' => trans('admin::messages.error-update')];
        }

        $resultStatus = false;
        $action = $inputs['action'];
        switch ($action) {
            case "update":
                $userIds = explode(',', $inputs['ids']);
                foreach ($userIds as $key => $userId) {
                    $id = (int) $userId;
                    $user = $this->getByIdWithTrashed($id);
                    if (!empty($user)) {
                        switch ($inputs['value']) {
                            case 'status-0': $user->status = 0;
                                break;
                            case 'status-1': $user->status = 1;
                                break;
                        }
                        $user->save();
                        $resultStatus = true;
                    }
                }

                break;
            case "delete":
                $userIds = explode(',', $inputs['ids']);
                foreach ($userIds as $key => $userId) {
                    $id = (int) $userId;
                    $user = $this->getByIdWithTrashed($id);
                    if (!empty($user)) {
                        $user->delete();
                        $resultStatus = true;
                    }
                }
                break;
            case "delete-hard":
                $userIds = explode(',', $inputs['ids']);
                foreach ($userIds as $key => $userId) {
                    $id = (int) $userId;
                    $user = $this->getByIdWithTrashed($id);
                    if (!empty($user)) {
                        $user->forceDelete();
                        $resultStatus = true;
                    }
                }
                break;
            case "restore":
                $userIds = explode(',', $inputs['ids']);
                foreach ($userIds as $key => $userId) {
                    $id = (int) $userId;
                    $user = $this->getByIdWithTrashed($id);
                    if (!empty($user)) {
                        $user->restore();
                        $resultStatus = true;
                    }
                }
                break;
            default:
                break;
        }

        if ($resultStatus) {
            $action = (!empty($inputs['action'])) ? $inputs['action'] : 'update';
            switch ($action) {
                case 'delete' :
                    $message = trans('admin::messages.deleted', ['name' => trans('admin::messages.user(s)')]);
                    break;
                case 'delete-hard' :
                    $message = trans('admin::messages.deleted-hard-msg', ['name' => trans('admin::messages.user(s)')]);
                    break;
                case 'restore' :
                    $message = trans('admin::messages.restored', ['name' => trans('admin::messages.user(s)')]);
                    break;
                case 'update' :
                default:
                    $message = trans('admin::messages.group-action-success');
            }
            $response = ['status' => 'success', 'message' => $message];
        } else {
            $response = ['status' => 'fail', 'message' => trans('admin::messages.error-update')];
        }

        return $response;
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
     * Trashed Admin users listing
     *
     * @param  array  $params
     * @return Response
     */
    public function trashedData($params = [])
    {
        $cacheKey = str_replace(['\\'], [''], __METHOD__) . ':' . md5(json_encode($params));
        $response = Cache::tags($this->model->table())->remember($cacheKey, $this->ttlCache, function() {
            return $this->model->select('*')->onlyTrashed()->get();
        });

        return $response;
    }

    /**
     * Save the Admin.
     *
     * @param  Modules\Admin\Models\User $user
     * @param  Array  $inputs
     * @return void
     */
    private function save($inputs, $user = '')
    {
        if (empty($user)) {
            $user = new $this->model;
            $allColumns = $user->getTableColumns($user->getTable());
            foreach ($inputs as $key => $value) {
                if (in_array($key, $allColumns)) {
                    $user->$key = $value;
                }
            }
        } else {
            foreach ($inputs as $key => $value) {
                if (isset($user->$key) && $value != "") {
                    $user->$key = $value;
                }
            }
        }

        if (!empty($inputs['password'])) {
            $user->password = bcrypt($inputs['password']);
        }

        $user->save();
        $this->updateAvatar($inputs, $user);

        return $user;
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
            $user = $this->save($inputs);
            if ($user) {
                if (isset($inputs['submit_save'])) {
                    $userLabel = trans('admin::messages.user');
                    $message = trans('admin::messages.added', ['name' => $userLabel]) . ' ' . trans('admin::messages.add-save-message', ['name' => $userLabel]);
                    $response['redirect'] = URL::to('admin/site-user/create');
                } else {
                    $message = trans('admin::controller/user.created');
                    $response['redirect'] = URL::to('admin/site-user');
                }
                $response['status'] = 'success';
                $response['message'] = $message;
            } else {
                $response['status'] = 'error';
                $response['message'] = trans('admin::messages.not-added', ['name' => trans('admin::messages.user')]);
            }

            return $response;
        } catch (Exception $e) {

            $exceptionDetails = $e->getMessage();
            $response['status'] = 'error';
            $response['message'] = trans('admin::messages.not-added', ['name' => trans('admin::messages.user')]) . "<br /><b> Error Details</b> - " . $exceptionDetails;
            Log::error(trans('admin::messages.not-added', ['name' => trans('admin::messages.user')]), ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);

            return $response;
        }
    }

    /**
     * Store a 
     * 
     * @param  array $inputs
     * @return void
     */
    public function createUser($inputs)
    {
        try {
            $user = $this->save($inputs);
            $response = ApiResponse::json($user);
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
    public function update($inputs, $user)
    {
        try {
            $user = $this->save($inputs, $user);

            if ($user) {
                $response['redirect'] = URL::to('admin/site-user');
                $response['status'] = 'success';
                $response['message'] = trans('admin::controller/user.updated');
            } else {
                $response['status'] = 'error';
                $response['message'] = trans('admin::messages.not-updated');
            }

            return $response;
        } catch (Exception $e) {

            $exceptionDetails = $e->getMessage();
            $response['status'] = 'error';
            $response['message'] = trans('admin::messages.not-updated') . "<br /><b> Error Details</b> - " . $exceptionDetails;
            Log::error("User update fail.", ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);

            return $response;
        }
    }

    /**
     * Update a admin.
     *
     * @param  array  $inputs
     * @param  Modules\Admin\Models\User $user
     * @return void
     */
    public function updateUser($inputs, $modelObj)
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
     * Get Admin Bulk Action collection.
     * @return Array
     */
    public function getAdminBulkActionSelect()
    {
        return ['' => 'Select', 'status-0' => 'Inactivate', 'status-1' => 'Activate', 'delete' => 'Delete'];
    }

    /**
     * Get Admin Bulk Action collection.
     * @return Array
     */
    public function getTrashBulkActionSelect()
    {
        return ['' => 'Select', 'delete-hard' => 'Delete', 'restore' => 'Restore'];
    }

    /**
     * Update user avatar.
     *
     * @param  array  $inputs
     * @param  Modules\Admin\Models\User $user
     * @return void
     */
    public function updateAvatar($inputs, $user)
    {
        if (!empty($inputs['avatar'])) {
            //unlink old file
            if (!empty($user->avatar)) {
                File::Delete(public_path() . ImageHelper::getUserUploadFolder($user->id) . $user->avatar);
            }
            $user->avatar = ImageHelper::uploadUserAvatar($inputs['avatar'], $user);
            $user->save();
        } else if (!empty($inputs['remove']) && ($inputs['remove'] == 'remove')) {
            $user->avatar = '';
            $user->save();
        } else {
            $user->save();
        }
    }

    /**
     * chekc field value present
     *
     * @param  string  $inputs
     * @return int
     */
    public function checkField($inputs = [])
    {
        if (!empty($inputs['field']) && !empty($inputs['value'])) {
            return $this->model
                    ->where($inputs['field'], '=', $inputs['value'])->count();
        }

        return false;
    }

    /**
     * give userId by username
     *
     * @param  string $userName
     * @return string
     */
    public function getUserIdByUsername($userName)
    {
        $cacheKey = str_replace(['\\'], [''], __METHOD__) . ':' . md5($userName);
        $response = Cache::tags($this->model->table())->remember($cacheKey, $this->ttlCache, function() use ($userName) {
            $user = $this->model->where('email', $userName)->get()->first();
            if (!empty($user)) {
                $data = $user->toArray();
                return $data['id'];
            }
        });

        return $response;
    }

    public function getLoginRules($inputs)
    {
        $accountType = (isset($inputs['account_type'])) ? $inputs['account_type'] : 0;
        switch ($accountType) {
            case 1:
                return [
                    'facebook_id' => 'required',
                    'access_token' => 'required'
                ];
            case 2:
                return [
                    'googleplus_id' => 'required',
                    'access_token' => 'required'
                ];
            default:
                return [
                    'email' => 'required',
                    'password' => 'required'
                ];
        }
    }

    public function getLoginUser($inputs)
    {
        $accountType = (isset($inputs['account_type'])) ? $inputs['account_type'] : 0;
        switch ($accountType) {
            case 1:
                return $this->model->where('facebook_id', $inputs['facebook_id'])->first();
            case 2:
                return $this->model->where('googleplus_id', $inputs['googleplus_id'])->first();
            default:
                $user = $this->model->where('email', $inputs['email'])->first();
                if (!empty($user->password) && \Hash::check($inputs['password'], $user->password)) {
                    return $user;
                }
                return false;
        }
    }
}
