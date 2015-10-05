<?php
/**
 * The helper library class for user image processing ang geting
 *
 *
 * @author Nilesh G. Pangul <nileshgpangul@gmail.com>
 * @package Admin
 * @since 1.0
 */

namespace Modules\Admin\Services\Helper;

use DB;

class ImageHelper
{

    /**
     * upload user avatar
     * @return String
     */
    public static function uploadUserAvatar($fileObj, $user = '', $fileName = '')
    {
        if (empty($fileName)) {
            $fileName = 'avatar' . '-' . time() . '.' . $fileObj->getClientOriginalExtension();
        }
        $path = self::getUserUploadFolder($user->id);
        $fileObj->move(public_path() . $path, $fileName);

        return $fileName;
    }

    /**
     * get user avatar upload folder path
     * @return String
     */
    public static function getUserUploadFolder($userId = '')
    {
        if (empty($userId)) {
            $userId = \Auth::user()->id;
        }
        $path = DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $userId . DIRECTORY_SEPARATOR;
        self::checkDirectory(public_path() . $path);

        return $path;
    }

    /**
     * check and create directory 
     */
    public static function checkDirectory($dirPath = '')
    {
        if (!\File::exists($dirPath)) {
            \File::makeDirectory($dirPath, 0775, true);
        }
    }

    /**
     * get default image link
     */
    public static function getDefaultImageLink()
    {
        return \URL::asset('images/default-user-icon-profile.png ');
    }

    /**
     * get default image 
     */
    public static function getDefaultImage($class = 'img-thumbnail img-responsive')
    {
        return \Form::image(self::getDefaultImageLink(), ' ', ['class' => $class]);
    }

    /**
     * check and create directory 
     */
    public static function getUserAvatar($userId = '', $avatar = '', $class = 'img-thumbnail img-responsive')
    {
        $default = self::getDefaultImageLink();
        if (!empty($userId) && empty($avatar)) {
            $user = DB::table('admins')->select('avatar')->where('id', $userId)->first();
            $avatar = $user->avatar;
        }
        if (!empty($avatar)) {

            return \HTML::image(\URL::asset(self::getUserUploadFolder($userId) . $avatar), $avatar, ['class' => $class, 'onerror' => 'this.src="' . $default . '"']);
        }

        return \HTML::image($default, ' ', ['class' => $class]);
    }
}
