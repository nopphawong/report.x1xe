<?php

namespace App\Controllers;

use App\Libraries\Portal;

class Pages extends BaseController
{
    public function index(): string
    {
        if (!session()->verified) {
            $params = (object) $this->request->getGet();
            $appVC = "{$_ENV["app.vc"]}";
            if (!isset($params->vc) || $appVC !== $params->vc) return view("adminlte/pages/forbidden", $this->viewData);
            session()->set(array('verified' => true));
        }
        return view("adminlte/pages/home", $this->viewData);
    }

    public function agentInfo($code, $key, $secret, $type): string
    {
        $portal = new Portal((object) array('key' => $key, 'secret' => $secret));
        $agent = $portal->agent_info(["code" => $code]);
        if (!$agent) return redirect()->to(previous_url());
        $session_data = (object) session()->get();
        $session_data->agent = (object) array(
            'code' => $agent->data->code,
            'key' => $agent->data->key,
            'secret' => $agent->data->secret,
            'name' => $agent->data->name,
        );
        session()->set((array) $session_data);
        $this->usePrimevue();
        // $use_libs = array('datatable', 'column');
        // foreach ($use_libs as $lib) {
        //     $this->usePrimevueLib($lib);
        // }

        switch ($type) {
            case 'registered':
                $view = "adminlte/pages/register_date";
                break;
            case 'cnt':
                $view = "adminlte/pages/deposit_times";
                break;
            default:
                $view = "adminlte/pages/register_code";
                break;
        }
        return view($view, $this->viewData);
    }
}
