<?php
/**
 * The helper library class for user image processing ang geting
 *
 *
 * @author NGP <corporate.ngp@gmail.com>

 
 */

namespace Modules\Admin\Services\Helper;


class Helper
{
    const ENC_SALT = 'orrelqraes256ctr';
    public static function generateUserToken($text)
    {
        return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, self::ENC_SALT, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
    }
    
}
