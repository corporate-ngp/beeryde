<?php

/**
 * This class is for managing basic api related functionalities
 * It will be used as base class for consuming third party api
 *
 * @author Nilesh G. Pangul <nileshgpangul@gmail.com>
 * @package Api
 */

namespace Modules\Api\Contracts;

use GuzzleHttp\Psr7;

abstract class BaseApi {

    protected $debug = false;

    /**
     * The guzzle client object to used by the model.
     *
     * @var object
     */
    protected $client = '';

    /**
     * The guzzle psr7 object to used by the model.
     *
     * @var object
     */
    protected $psr7 = '';

    /**
     * The api config object to used by the model.
     *
     * @var array
     */
    protected $apiConfig = '';

    /**
     * The api base url to used by the model.
     *
     * @var string
     */
    protected $apiBaseUrl = '';

    /**
     * The project specific api url configuration name.
     *
     * @var string
     */
    protected $moduleName = '';

    /**
     * The model specific path to used by the model.
     *
     * @var string
     */
    protected $base = '';

    /**
     * Set if require to pass authentication token in header
     *
     * @var string
     */
    protected $getauth = 0;

    /**
     * Time to leave catch // 60 minutes * 10 = 10 hours
     *
     * @var string
     */
    protected $ttl = 600;

    /**
     * Get a record matching the param
     *
     * @var string
     */
    protected $find = '';

    /**
     * Get all records
     *
     * @var string
     */
    protected $all = '';

    /**
     * Define data create api call method name for insert records
     *
     * @var string
     */
    protected $create = '';

    /**
     * Define data update api call method name for update records
     *
     * @var string
     */
    protected $update = '';

    /**
     * Define data delete api call method name for delete records
     *
     * @var string
     */
    protected $delete = '';

    /**
     * Define data api call url
     *
     * @var string
     */
    protected $url = '';
    protected $get = '';

    public function __construct() {
        $this->apiConfig = \Config::get('api.' . $this->moduleName);
        $this->apiBaseUrl = $this->apiConfig['api_url'] . $this->base;
    }

    /**
     * Get the API Call with help of Guzzle
     *
     * @return mixed
     */
    public function get($params = []) {
        $response = [];
        $apiurl = $this->apiBaseUrl . $this->get;       
        $data['query'] = $params;
        try {
            $response = $this->call($apiurl, 'get', $data);
        } catch (Exception $e) {
            \Log::error(__METHOD__ . ' : ' . $e->getMessage());
        }

        return $response;
    }

    /**
     * Create the API Call of with help of Guzzle
     *
     * @return mixed
     */
    public function post($params = []) {
        $response = [];
        $apiurl = $this->apiBaseUrl . $this->post;
        $data['body'] = $params;

        try {
            $response = $this->call($apiurl, 'post', $data);
        } catch (Exception $e) {
            \Log::error(__METHOD__ . ' : ' . $e->getMessage());
        }

        return $response;
    }

    /**
     * @brief   Create new record
     *
     * @return  mixed
     */
    public function create($params = []) {
        $apiurl = $this->apiBaseUrl . $this->create;
        $data = [];
        $data['postData'] = $params;

        $response = $this->call($apiurl, 'get', $data);

        return $response->json();
    }

    /**
     * Create the Guzzle POST OR GET request
     *
     * @return mixed
     */
    protected function call($requestUrl, $requestType, $params = []) {
        $result = [];
        if (empty($this->client)) {
            $this->client = new \GuzzleHttp\Client();
            //  $this->client->setDefaultOption('verify', false);
        }

        $requestMethod = ['get', 'post', 'put', 'delete', 'head', 'options'];

        if (empty($requestUrl) || empty($requestType) || !in_array($requestType, $requestMethod)) {
            throw new Exception('"requestType" and "requestUrl" are require parameter. requestType options "get,post,delete,etc."');
        }

        if (true === $this->debug) {
            if (strpos($requestUrl, '?') !== false) {
                $requestUrl .= '&XDEBUG_PROFILE=1';
            } else {
                $requestUrl .= '?XDEBUG_PROFILE=1';
            }

            echo "RequestUrl: {$requestUrl} <br />";
            echo "RequestType: {$requestType} <br />";
            echo 'Params: ', json_encode($params), '<br />';
        }

        try {
            $response = $this->client->$requestType($requestUrl, $params);
            $statusCode = $response->getStatusCode();
            if (true === $this->debug) {
                echo 'Response: ', print_r($response->__toString());
                //exit;
            }
            if (200 == $statusCode) {
                $stream = Psr7\stream_for($response->getBody());
                $result = $stream->getContents();
            } else {
                $result = $response->getReasonPhrase();
            }
        } catch (Exception $e) {
            if (true === $this->debug) {
                echo 'BaseApi Call Method Exception: ' . $e->getMessage();
                exit;
            }
            throw new Exception('BaseApi Call Method Exception: ' . $e->getMessage());
        }

        return $result;
    }

    /**
     * Catch The Data that if not exist
     *
     * @return mixed
     */
    protected function catchData($key, $data = null) {
        $value = [];

        if (empty($key) || empty($this->catchUniqueKey)) {
            throw new Exception('"catchUniqueKey" is require property in model.');
        }
        $key = "{$this->moduleName}_{$this->catchUniqueKey}";

        if ($this->isCatchRequire || !Cache::has($key)) {
            $value = $data;
            Cache::add($key, $value, $this->ttl);
        } else {
            $value = Cache::get($key);
        }

        return $value;
    }

}
