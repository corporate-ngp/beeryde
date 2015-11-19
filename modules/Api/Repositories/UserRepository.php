<?php

/**
 * This class is to create user related functionalities
 *
 *
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api
 */

namespace Modules\Api\Repositories;

use \App\Libraries\ApiResponse as ApiResponse;
use \Modules\Api\Contracts\SmsGatewayApi;
use \Modules\Api\Models\User as User;
use Input;
use Auth;
use Cache;
use Hash;

class UserRepository extends BaseRepository {

    /**
     * Create a new UserRepository instance.
     *
     * @param  Modules\Api\Models\Users $user
     * @return void
     *
     */
    public function __construct(User $user) {
        $this->model = $user;
    }

    /**
     * rules to be applied for update user params
     * @return array
     */
    public static function getUpdateRules() {
        return User::getUpdateRules();
    }

    /**
     * rules to be applied for crewate user
     * @return array
     */
    public static function getCreateRules() {
        return User::getCreateRules();
    }

    /**
     * To update user's profile with profile picture, display name, emergency contact no. etc.
     * @param int phone no.
     * @param string display name
     * @param int emergency contact no.1
     * @param int emergency contact no.2
     * @return array
     */
    public function update($input) {

        $user = null;
        $phone = $input['phone'];
        $params = [];
        $params['phone'] = $phone;
        $cacheKey = str_replace(['\\'], [''], __METHOD__) . ':' . md5(json_encode($params));
        $user = Cache::tags(User::table())->remember($cacheKey, $this->ttlCache, function() use ($phone) {
            return $this->model->where('phone', '=', $phone)->where('is_verified', '=', 1)->first();
        });
        if (!($user instanceof User)) {
            return ApiResponse::error('User is not registered or Not Verified.');
        }
        $update = [];
        if (Input::hasFile('image')) {

            $orgFilename = Input::file('image')->getClientOriginalName();
            $orgFilename = preg_replace("/[^a-zA-Z0-9.]+/", "", $orgFilename);
            $newFilename = $user->user_id . '_' . $orgFilename;
            Input::file('image')->move(public_path() . '/uploads', $newFilename);
            $path = 'public/uploads/' . $newFilename;
            $update['profile_picture'] = $path;
        }
        $input = Input::except('_method', 'image');
        $update = array_merge($update, $input);
        foreach ($update as $column => $value) {
            $user->$column = $value;
        }
        $user->save();
        return $user->toArray();
    }

    /**
     * User logs out of the system
     * @return json message
     */
    public function logout() {
        
    }
    
    /**
     * Store a Admin.
     *
     * @param  array $input
     * @return void
     */
    public function create($input)
    {

        try {
            //create user
            $input['password'] = (!empty($input['password'])) ? bcrypt($input['password']) : bcrypt(time());
            $user = SiteUser::create($input);
            $user->password = $input['password'];
            $user->save();
            $this->updateAvatar($input, $user);
            if ($user) {
                if (isset($input['submit_save'])) {
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
}
