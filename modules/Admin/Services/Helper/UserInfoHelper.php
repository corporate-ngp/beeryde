<?php
/**
 * The helper library class for getting information of a logged in user from storage
 *
 *
 * @author NGP <corporate.ngp@gmail.com>

 
 */

namespace Modules\Admin\Services\Helper;

use Auth;
use Modules\Admin\Models\User;

class UserInfoHelper
{

    /**
     * fetch user details
     * @return String
     */
    public static function getAuthUserInfo()
    {
        return $userinfo = User::find(Auth::user()->id);
    }
}
