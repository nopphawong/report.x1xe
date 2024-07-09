<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];
    protected $viewData = [
        "includes_js" => [],
        "includes_css" => [],
        "vuejs" => [],
    ];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Load helpers.
        helper(['html']);

        $this->addJs(base_url("assets/js/utils.js?v=0.01c"));
        $this->addCss(base_url("assets/css/main.css?v=0.01a"));

        $path = implode("/", $request->uri->getSegments());
        $path_array = explode("/", $path);
        $this->viewData['title'] = 'Report x1xe';
        $this->viewData['version'] = 'v1.2';
        $this->viewData['path'] = $path;
        $this->viewData['last_path'] = $path_array[count($path_array) - 1];
    }

    public function addJs($js, $key = "includes_js")
    {
        if (is_array($js)) $this->viewData[$key] = array_merge($this->viewData[$key], $js);
        else if (is_string($js)) $this->viewData[$key][] = $js;
    }

    public function addCss($css, $key = "includes_css")
    {
        if (is_array($css)) $this->viewData[$key] = array_merge($this->viewData[$key], $css);
        else if (is_string($css)) $this->viewData[$key][] = $css;
    }
    public function usePrimevue()
    {
        // $this->addCss("https://unpkg.com/primevue/resources/themes/lara-light-green/theme.css");
        $this->addJs("https://unpkg.com/primevue@4.0.0/umd/primevue.min.js", "vuejs");
        $this->addJs("https://unpkg.com/@primevue/themes@4.0.0/umd/aura.min.js", "vuejs");
    }
    public function usePrimevueLib($name)
    {
        $this->addJs("https://unpkg.com/primevue/{$name}/{$name}.min.js", "vuejs");
    }
    public function setView($path)
    {
        return view($path, $this->viewData);
    }
}
