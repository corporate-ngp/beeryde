<?php

namespace Modules\Api\Repositories;

use \Modules\Api\Repositories\UserRepository as UserRepo,
    \Modules\Api\Repositories\TokenRepository as TokenRepo,
    Validator,
    App\Libraries\ApiResponse,
    Input,
    Hash;

class UserService {

    private $user;
    private $token;

    public function __construct(UserRepo $user, TokenRepo $token) {
        $this->user = $user;
        $this->token = $token;
    }

    public function createNew($input) {
        $user = [];
        $validator = Validator::make($input, UserRepo::getCreateRules());

        if ($validator->passes()) {
            $data = [];
            $data['phone'] = $input['phone'];
            $data['password'] = Hash::make($input['password']);
            // mt_rand faster than rand
            $data['mobile_verification'] = mt_rand(10000, 99999);

            if (empty(array_filter($user = $this->user->create($data)))) {
                return ApiResponse::error('An error occured. Please, try again.');
            }
        } else {
            return ApiResponse::validation($validator);
        }
        try {
            $client = new \GuzzleHttp\Client();
            $request = $client->get('http://fastalerts.in/api/v1/sms/single.json?token=9f7e21ba-67aa-11e3-8294-3f46f268024e&sender_id=GFTAXI&route=TRANS&unicode=true&flash=true&msisdn=' . $data['phone'] . '&text=' . $data['mobile_verification'])->getBody();
            $records = json_decode($request, true);

            if ($records['fastalerts']['status'] == 'Success') {
                $user['sms_status'] = 'sent successfully';
            } else {
                $user['sms_status'] = 'failed';
            }
            return ApiResponse::json($user);
        } catch (GuzzleHttpExceptionBadResponseException $e) {
            \Log::error(explode('n', $e->getResponse()));
        }
    }

    /**
     * 	Authenticate a registered user, with its phone and password
     */
    public function authenticate($input) {

        $user = null;
        $token = '';
        $validator = Validator::make($input, UserRepo::getAuthRules());

        if ($validator->passes()) {
            $authUser = $this->user->isValidUser($input['phone']);
            if ($authUser) {
                if (Hash::check($input['password'], $authUser->password)) {
                    $this->token->toRemove($input['device_id'], $input['device_os']);
                    $data = [];
                    $data['user_id'] = $authUser->user_id;
                    $data['device_id'] = $input['device_id'];
                    $data['device_os'] = $input['device_os'];
                    $data['device_token'] = $input['device_token'];
                    $tokenArr = $this->token->createNew($data);
                    $tokenArr['user'] = $authUser;
                } else {
                    $token = ApiResponse::error('Incorrect password.');
                }
            }
        } else {
            return ApiResponse::validation($validator);
        }

        return ApiResponse::json($tokenArr);
    }

    /**
     * Match verification code entered by user and code stored for that particular mobile number
     *
     */
    public function verify($input) {

        $message = '';
        $validator = Validator::make($input, UserRepo::getVerifyRules());
        if ($validator->passes()) {
            return $this->user->verify($input);
        } else {
            return ApiResponse::validation($validator);
        }
    }

    /**
     * Send verification code through sms
     *
     */
    public function forgot($input) {

        $validator = Validator::make($input, UserRepo::getForgotRules());
        if ($validator->passes()) {
            $user = $this->user->forgot($input);
            try {
                $smsResponse = [];
                $client = new \GuzzleHttp\Client();
                $request = $client->get('http://fastalerts.in/api/v1/sms/single.json?token=9f7e21ba-67aa-11e3-8294-3f46f268024e&sender_id=GFTAXI&route=TRANS&unicode=true&flash=true&msisdn=' . $user->phone . '&text=' . $user->mobile_verification)->getBody();
                $records = json_decode($request, true);
                if ($records['fastalerts']['status'] == 'Success') {
                    $smsResponse['sms_status'] = 'sent successfully';
                } else {
                    $smsResponse['sms_status'] = 'failed';
                }
                return ApiResponse::json($smsResponse);
            } catch (GuzzleHttpExceptionBadResponseException $e) {
                \Log::error(explode('n', $e->getResponse()));
            }
        } else {
            return ApiResponse::validation($validator);
        }
    }

    /**
     * User enters verification code received by forgot password and new password to reset
     *
     */
    public function reset($input) {

        $validator = Validator::make($input, UserRepo::getResetRules());
        if ($validator->passes()) {
            return $this->user->reset($input);
        } else {
            return ApiResponse::validation($validator);
        }
    }

    /**
     * Save optional details of user like display name, email, emergency contact no.s, profile picture by using phone no.
     *
     */
    public function update($input) {

        $validator = Validator::make($input, UserRepo::getUserDetailsRules());
        if ($validator->passes()) {
            return $this->user->update($input);
        } else {
            return ApiResponse::validation($validator);
        }
    }

    /**
     * 	Logout a user: remove the specified active token from the database
     * 	@param user User
     */
    public function logout($id, $input) {

        $validator = Validator::make($input, TokenRepo::getTokenRules());
        if ($validator->passes()) {
            return $this->user->logout($id, $input['token']);
        } else {
            return ApiResponse::validation($validator);
        }
    }

}
