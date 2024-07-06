<?php

namespace App\Controllers\api;

use App\Controllers\api\BaseController;
use App\Libraries\Portal;

class Agent extends BaseController
{
    public function list()
    {
        $body = $this->getPost();
        $portal = new Portal();

        $response = $portal->agent_list($body);
        if (!$response->status) return $this->sendData(null, $response->message, false);
        return $this->sendData($response->data);
    }

    public function channels()
    {
        if(!session()->agent && !session()->agent->key) return $this->sendData(null, 'agent not found.', false);
        $portal = new Portal(session()->agent);
        $response = $portal->channel_list();
        if (!$response->status) return $this->sendData(null, $response->message, false);
        return $this->sendData($response->data);
    }
}
