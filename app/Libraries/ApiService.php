<?php

namespace App\Libraries;

use Exception;

class ApiService
{
    private $curl;
    private $secret;
    private $key;

    public function __construct($agent = null)
    {
        $this->curl = service("curlrequest", ["baseURI" => "{$_ENV["api.apiURL"]}"]);
        if ($agent) $this->set_agent($agent);
    }

    public function set_agent($agent)
    {
        $this->secret = $agent->secret;
        $this->key = $agent->key;
    }

    // Report
    public function register_lists_by_date($data = array())
    {
        return self::post("r_registerlistsbydate", $data);
    }

    public function register_lists_by_cnt($data = array())
    {
        return self::post("r_registerlistsbycnt", $data);
    }

    public function register_lists_by_code($data = array())
    {
        return self::post("r_registerlistsbycode", $data);
    }
    /* ========================================================================== */

    protected function post($path, $data = array())
    {
        $body = array_merge(
            ['appid' => $this->key],
            $data
        );

        $seconds = round((microtime(true) * 1000));
        $body['time'] = $seconds;
        $hash = self::hashdata($body, $this->secret);
        $body['hash'] = $hash;
        $response = $this->curl->post("{$path}", ["json" => $body]);
        log_message("alert", "path: {$path} :: " . json_encode($data));
        $result = self::prepare_result($response);
        log_message("alert", "path: {$path} :: " . json_encode($result));
        return $result;
    }

    protected function get($path)
    {
        $response = $this->curl->get($path);
        return self::prepare_result($response);
    }

    protected function hashdata($array, $secret)
    {
        $array = array_change_key_case($array, CASE_LOWER);
        ksort($array);
        $rawData = '';
        foreach ($array as $Key => $Value) {
            $rawData .=  $Key . '=' . $Value . '&';
        }
        $rawData  = substr($rawData, 0, -1);

        $rawData .= $secret;

        $hash     = md5($rawData);

        return $hash;
    }

    protected function prepare_result($response)
    {
        try {
            $result = json_decode($response->getBody());
            if (json_last_error() !== JSON_ERROR_NONE) {
                return (object) array(
                    "status" => false,
                    "message" => $response->getBody(),
                );
            }
            return $result;
        } catch (Exception $ex) {
            return (object) array(
                "status" => false,
                "message" => $ex->getMessage(),
            );
        }
    }
}
