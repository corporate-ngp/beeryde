<?php

/**
 * The class for verifying oauth on the basis of email and password
 * 
 * 
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api
 */

namespace Modules\Api\Oauth2\Verifier;

use Auth;
use DB;
use \Illuminate\Support\Facades\Hash;

class OauthVerifier {

    public function verify($username, $password) {
        // prep credentials
        $credentials = [
            'email' => $username,
            'password' => $password,
        ];

        //Perform Auth specific check
        if (Auth::once($credentials)) {
            return Auth::user()->user_id;
        } else {
            return false;
        }

        // perform table specific check
        $user = DB::table('users')
                ->where('users.email', $credentials['email'])
                ->first();

        // found a user returning an ID
        if ($user) {
            // passwords match?
            if (Hash::check($credentials['password'], $user->password)) {
                return $user->user_id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
