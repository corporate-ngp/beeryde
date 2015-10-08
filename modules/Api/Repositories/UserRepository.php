<?php

/**
 * This class is to create user related functionalities
 *
 *
 * @author Nilesh G. Pangul <nileshgpangul@gmail.com>
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
     * rules to be applied for update phone number
     * @return array
     */
    public static function getUpdatePhoneRules() {
        return User::getUpdatePhoneRules();
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
     * To check if user is existing and is active
     * @param string $countryCode
     * @param string $phone
     * @return boolean
     */
    public function isActive($countryCode, $phone) {
        $params = [];
        $params['phone'] = $phone;
        $params['country_code'] = $countryCode;
        $cacheKey = str_replace(['\\'], [''], __METHOD__) . ':' . md5(json_encode($params));
        $user = Cache::tags(User::table())->remember($cacheKey, $this->ttlCache, function() use ($countryCode, $phone) {
            return $this->model->where('country_code', '=', $countryCode)->where('phone', '=', $phone)->where('is_active', '=', 1)->first();
        });
        return $this->isInstanceOf($user);
    }

    /**
     * To check is instanceof User
     * @param object $user
     * @return booelan
     */
    public function isInstanceOf($user) {
        if (!($user instanceof User)) {
            return false;
        }
        return $user;
    }

    /**
     * To check if user is existing and is active and return user array
     * @param string $countryCode
     * @param string $phone
     * @return object $user on successful false on failure
     */
    public function getExisting($countryCode, $phone) {
        $params = [];
        $params['phone'] = $phone;
        $params['country_code'] = $countryCode;
        $cacheKey = str_replace(['\\'], [''], __METHOD__) . ':' . md5(json_encode($params));
        $user = Cache::tags(User::table())->remember($cacheKey, $this->ttlCache, function() use ($countryCode, $phone) {
            return $this->model->where('country_code', '=', $countryCode)->where('phone', '=', $phone)->where('is_active', '=', 1)->first();
        });
        return $this->isInstanceOf($user);
    }

    /**
     * To update login status of User
     * @param array $paramsArr
     * @param object $user
     */
    public function updateLogin($paramsArr, $user) {
        foreach ($paramsArr as $column => $value) {
            $user->$column = $value;
        }
        $user->save();
    }

    /**
     * To update phone number of User
     * 	@param new_country_code
     *  @param new_phone
     *  @param old_country_code - to check existance of old number
     *  @param old_phone - to check existance of old number
     *  @param otp_auth - send otp request to validate new phone number
     *  @return boolean
     */
    public function updatePhone($newCountryCode, $newPhone, $oldCountryCode, $oldPhone, $otp) {
        $response = false;
        $user = $this->getExisting($oldCountryCode, $oldPhone);
        if ($user) {
            $user->country_code = $newCountryCode;
            $user->phone = $newPhone;
            $user->save();
            $response = true;
        } 
        return $response;
    }

}
