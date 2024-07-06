<?php

namespace App\Controllers\api;

use App\Controllers\api\BaseController;
use App\Libraries\ApiService;

class Report extends BaseController
{
    public function registerByDate()
    {
        $body = $this->getPost();
        $service = new ApiService(session()->agent);
        $response = $service->register_lists_by_date(array('s_date' => $body->s_date, 'e_date' => $body->e_date));
        if (!$response->status) return $this->sendData(null, $response->message, false);
        return $this->sendData($response->data);
    }

    public function depositTimes()
    {
        $body = $this->getPost();
        $service = new ApiService(session()->agent);
        $response = $service->register_lists_by_cnt(array('s_date' => $body->s_date, 'e_date' => $body->e_date, 'cnt' => $body->cnt));
        if (!$response->status) return $this->sendData(null, $response->message, false);
        return $this->sendData($response->data);
    }

    public function registerByCode()
    {
        $body = $this->getPost();
        $service = new ApiService(session()->agent);
        $response = $service->register_lists_by_code(array('s_date' => $body->s_date, 'e_date' => $body->e_date, 'code' => $body->code));
        if (!$response->status) return $this->sendData(null, $response->message, false);
        return $this->sendData($response->data);
    }
}
