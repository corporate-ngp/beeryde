<?php

namespace Modules\Api;

use Auth,
    DB,
    \Illuminate\Support\Facades\Hash,
    Modules\Api\Repositories\UserRepository as UserRepo;

class OauthVerifier {

    private $userRepo;
   
    public function __construct(UserRepo $userRepo) {
        $this->userRepo = $userRepo;
    }

    public function verify($phone, $otpRequest) {         
        $credentials = [
            'phone' => $phone,            
        ];        
        
        //check if phone no exists and user is active  ,check if user is logged in or not.      
        if ($this->userRepo->isActive($phone)) {           
            return $this->login($phone, $otpRequest);
        }
        return $this->register($phone, $otpRequest);
    }

    public function login($phone, $otpRequest) {      
        //execute otp request ,validate its response, retrieve phone no once validated       
        $verified = $this->userRepo->runOtpRequest($otpRequest);         
        $otpPhone = substr($verified['phone_number'], 1, strlen($verified['phone_number']));                                           
        //compare otp response phone no with phone no in db
        $user = $this->userRepo->getExisting($otpPhone);
        //check below methods compare phone nos
        if ($this->userRepo->comparePhoneNos($phone, $user->phone)) {
        //if both no.s are same generate token and return, user is now is_login=1                
            $this->userRepo->updateLogin(array('is_login' => 1), $user);
            return true;
        }
    }

    public function register($phone, $otpRequest) {
        //validate phone no.
        //execute otp response ,validate its response, retrieve phone no once validated        
        $verified = $this->userRepo->runOtpRequest($otpRequest);
        $phone = $verified['phone_number'];        
        //compare otp response phone no with phone no in input
        if ($this->userRepo->comparePhoneNos($otpPhone, $user->phone)) {
            //if both no.s are same create user with phone, update login status as 1
            $data['phone'] = $phone;
            $data['password'] = 'pass';
            $data['is_login'] = 1;
            $user = $this->userRepo->create($data);
            return true;
        }
        //return generated token 
    }
        
}
