<?php

/**
 * This class is for managing user related functionalities
 *
 *
 * @author Nilesh G. Pangul <nileshgpangul@gmail.com>
 * @package Api
 */

namespace Modules\Api\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Api\Repositories\UserRepository as UserRepo;
use Modules\Api\Repositories\TempUserOtpRepository as TempUserOtpRepo;
use Validator;
use App\Libraries\ApiResponse;
use Input;
use Exception;
use Log;
use Auth;

class UserController extends Controller {

    /**
     * The UserRepository instance.
     *
     * @var Modules\Api\Repositories\UserRepository
     */
    private $userRepo;

    /**
     * The UserRepository instance.
     *
     * @var Modules\Api\Repositories\TempUserOtpRepository
     */
    private $tempUserOtpRepo;

    /**
     * Create a new UserController instance.
     * @param  Modules\Admin\Repositories\UserRepository $userRepo,
     *         Modules\Admin\Repositories\TempUserOtpRepository $tempUserOtpRepo,              
     * @return void
     */
    public function __construct(UserRepo $userRepo, TempUserOtpRepo $tempUserOtpRepo) {
        $this->userRepo = $userRepo;
        $this->tempUserOtpRepo = $tempUserOtpRepo;
    }

    /**
     * List all the data
     *
     * @return view
     */
    public function index() {
        return view('api::index');
    }

    /**
     * Save optional details of user like display name, email, emergency contact no.s, profile picture by using phone no.
     * All params get by Input
     * @param any user related param will be updated
     * @return json
     */
    public function update() {
        $input = Input::all();
        $validator = Validator::make($input, UserRepo::getUpdateRules());
        if ($validator->passes()) {
            return $this->userRepo->update($input);
        } else {
            return ApiResponse::validation($validator);
        }
    }

    /**
     * 	Logout a user: remove the specified active token from the database
     * 	@param user User
     *  @return json
     */
    public function logout() {
        
    }

    /**
     * 	Change phone number of user
     *  All params get by Input
     * 	@param new_country_code
     *  @param new_phone
     *  @param old_country_code - to check existance of old number
     *  @param old_phone - to check existance of old number
     *  @param otp - otp entered by user which is sent via http://fastalerts.in 
     *  @return json
     */
    public function updatePhone() {        
        $response = false;
        try {                        
            $input = Input::all();
            $validator = Validator::make($input, UserRepo::getUpdatePhoneRules());
            if ($validator->passes()) {
                //verify otp
                $isVerified = $this->tempUserOtpRepo->validateOtp($input['new_country_code'], $input['new_phone'], $input['otp']);
                if ($isVerified) {
                    //update phone no
                    $isUpdated = $this->userRepo->updatePhone($input['new_country_code'], $input['new_phone'], $input['old_country_code'], $input['old_phone'], $input['otp']);
                    if ($isUpdated) {
                        Log::info('Phone number updated successfully', ['old_country_code' => $input['old_country_code'], 'old_phone' => $input['old_phone'], 'new_country_code' => $input['new_country_code'], 'new_phone' => $input['new_phone'], 'otp' => $input['otp']]);
                        $response = ApiResponse::json('Phone number updated successfully');
                    } else {
                        $response = ApiResponse::error('Can not update phone number');
                    }
                }
            } else {
                Log::info('Input params can not be validated', ['old_country_code' => $input['old_country_code'], 'old_phone' => $input['old_phone'], 'new_country_code' => $input['new_country_code'], 'new_phone' => $input['new_phone'], 'otp' => $input['otp']]);
                $response = ApiResponse::validation($validator);
            }
        } catch (Exception $e) {
            Log::info('Failed to update phone number.', ['error_message' => $e->getMessage()]);
        }
        return $response;
    }

    /**
     * verify phone no by sending otp to phone
     * @param string country_code
     * @param string phone
     * @return json
     */
    public function sendOtp() {
        $response = false;
        try {
            $input = Input::all();
            $validator = Validator::make($input, TempUserOtpRepo::getOtpRules());
            if ($validator->passes()) {
                $response = $this->tempUserOtpRepo->sendOtp($input['country_code'], $input['phone']);
            } else {
                Log::info('Input params can not be validated', ['country_code' => $input['country_code'], 'phone' => $input['phone']]);
                $response = ApiResponse::validation($validator);
            }
        } catch (Exception $e) {
            Log::info('Failed to send OTP.', ['error_message' => $e->getMessage()]);
        }
        return $response;
    }

}
