<?php

/**
 * This class is to create device tokens related functionalities
 * 
 * 
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api
 */

namespace Modules\Api\Repositories;

use \Modules\Api\Models\Token as Token;
use Cache;

class TokenRepository extends BaseRepository {

    /**
     * Create a new TokenRepository instance.
     *
     * @param  Modules\Api\Models\Tokens $token
     * @return void
     * 
     */
    public function __construct(Token $token) {
        $this->model = $token;
    }

    /**
     * create random key for token
     * @param int size
     * @return int
     */
    public static function randomKey($size) {
        do {
            $key = openssl_random_pseudo_bytes($size, $strongEnough);
        } while (!$strongEnough);

        $key = str_replace('+', '', base64_encode($key));
        $key = str_replace('/', '', $key);

        return base64_encode($key);
    }

    /**
     * generate new token instance
     * @return token object
     */
    public static function getInstance() {
        $token = new Token();
        $token->key = self::randomKey(32);

        return $token;
    }

    /**
     * get token rules defined in model
     * @return token
     */
    public static function getTokenRules() {
        return Token::getTokenRules();
    }

    /**
     * clear old sessions for any user with: same(device_id, os)       
     * 
     */
    public function toRemove($deviceId = null, $deviceType = null) {
        $params = [];
        $params['id'] = $deviceId;
        $params['type'] = $deviceType;
        $cacheKey = str_replace(['\\'], [''], __METHOD__) . ':' . md5(json_encode($params));
        $toRemove = Cache::tags(Token::table())->remember($cacheKey, $this->ttlCache, function() use ($deviceId, $deviceType) {
            return $this->model->where('device_id', '=', $deviceId)->where('device_os', '=', $deviceType)->delete();
        });
        return $toRemove;
    }

    /**
     * get token with input key
     * @param $key
     * @return token object
     */
    public function getToken($key) {
        $token = $this->model->where('key', '=', $key)->first();
        if (!($token instanceof Token)) {
            return false;
        } else {
            return $token;
        }
    }
        
}
