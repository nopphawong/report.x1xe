<?php

namespace App\Controllers\api;

use CodeIgniter\RESTful\ResourceController;

class BaseController extends ResourceController {
    protected $session;

    public function __construct() {
        $this->session = session();
    }
    protected function sendData($data = null, $message = "Successful !", $status = true, $custom = array()) {
        $data = array("status" => $status, "message" => $message, "data" => $data,);
        if ($custom) $data = array_merge($data, $custom);
        return $this->respond($data);
    }
    protected function sendError($message = "Fail !", $data = null) {
        $data = array(
            "status" => false,
            "message" => $message,
            "data" => $data,
        );
        return $this->respond($data);
    }
    protected function getPost($index = false) {
        if ($this->request->is('json')) $body = !$index ? $this->request->getVar() : $this->request->getVar($index);
        else $body =  !$index ? $this->request->getPost() : $this->request->getPost($index);
        return (object) (!empty($body) ? $body : array());
    }
}