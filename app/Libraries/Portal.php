<?php

namespace App\Libraries;

use Exception;

class Portal
{
    private $curl;
    private $secret;
    private $key;

    public function __construct($agent = null)
    {
        $this->curl = service("curlrequest", ["baseURI" => "{$_ENV["api.portalURL"]}"]);
        if ($agent) $this->set_agent($agent);
    }

    public function set_agent($agent)
    {
        $this->secret = $agent->secret;
        $this->key = $agent->key;
    }

    // Agent
    public function agent_list($data = array())
    {
        return self::post("agent/list", $data);
    }
    public function agent_info($data = array())
    {
        return self::post("agent/info", $data);
    }

    // Channels
    public function channel_list($data = array())
    {
        return self:: post("channel/list", $data);
    }
   
    /* ========================================================================== */

    protected function post($path, $data = array())
    {
        $data = (object) $data;
        $data->secret = $this->secret;
        $data->key = $this->key;
        $body = self::hash_data($data);
        log_message("alert", "path: {$path} :: " . $body);
        $response = $this->curl->post("{$path}", ["json" => $data]);
        $result = self::prepare_result($response);
        log_message("alert", "path: {$path} :: " . json_encode($result));
        return $result;
    }

    protected function get($path)
    {
        $response = $this->curl->get($path);
        return self::prepare_result($response);
    }

    protected function hash_data($array)
    {
        if (empty($array)) $array = array();
        return json_encode($array);
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
