<?php

/**
 * The class for verifying oauth on the basis of OTP request validation
 * 
 * 
 * @author Nilesh G. Pangul <nileshgpangul@gmail.com>
 * @package Api
 */

namespace Modules\Api\Oauth2\Verifier;

use Auth;
use DB;
use \Modules\Api\Repositories\UserRepository as UserRepo;
use Log;
use Exception;

class OauthMobileVerifier {

    private $userRepo;

    public function __construct(UserRepo $userRepo) {
        $this->userRepo = $userRepo;
    }

    /**
     * callback function of OAuth returning access_token on login or register
     * @param string $countryCode
     * @param string $phone     
     * @param int $otp     
     * @param string $firstname     
     * @param string $lastname     
     * @return json access_token 
     */
    public function verify($countryCode, $phone, $otp, $firstName, $lastName) {        
        //check if phone no exists and user is active.    
        if ($user = $this->userRepo->getExisting($countryCode, $phone)) {
            return $this->login($countryCode, $phone, $otp, $user);
        } else {
            return $this->register($countryCode, $phone, $otp, $firstName, $lastName);
        }
    }

    /**
     * for existing user who tries to login
     * send otp to phone no, store it in tempuser table with phone no, compare input otp with this otp
     * update login status of user as is_login
     * @param string $countryCode 
     * @param int $phone     
     * @param int $otp     
     * @param object $user - existing user
     * @return boolean - with access token
     */
    public function login($countryCode, $phone, $otp, $user) {
        try {
            $response = false;
            $isVerified = '';
            if ($isVerified) {
                $this->userRepo->updateLogin(array('is_login' => 1), $user);
                Log::info('User logged in successfully', ['id' => $user->user_id]);
                $response = $user->user_id;
            } 
            return $response;
        } catch (Exception $e) {
            Log::info('User failed to login', ['error_message' => $e->getMessage()]);
        }
    }

    /**
     * for new user who tries to register
     * send otp to phone no, store it in tempuser table with phone no, compare input otp with this otp
     * @param string $countryCode 
     * @param int $phone 
     * @param int $otp
     * @param string $firstName optional field
     * @param string $lastName optional field
     * @return boolean - with access token
     */
    public function register($countryCode, $phone, $otp, $firstName, $lastName) {
        try {
            $response = false;
            $isVerified = '';
            if ($isVerified) {
                $data = [];
                $data['country_code'] = $countryCode;
                $data['phone'] = $phone;
                $data['name'] = $firstName . ' ' . $lastName;                
                $data['is_active'] = 1;
                $data['is_login'] = 1;
                $user = $this->userRepo->create($data);
                Log::info('User registered successfully', ['id' => $user['user_id']]);
                $response = $user['user_id'];
            } 
            return $response;
        } catch (Exception $e) {
            Log::info('User failed to register', ['error_message' => $e->getMessage()]);
        }
    }

}
