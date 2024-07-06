<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// PAGE
$verifyGuard = ['filter' => 'verifyGuard'];
$routes->get('/', 'Pages::index');
$routes->get('/agent/(:segment)/(:segment)/(:segment)/(:segment)', 'Pages::agentInfo/$1/$2/$3/$4', $verifyGuard);


// API
$routes->post('agent/list', 'api\Agent::list');
$routes->post('agent/channels', 'api\Agent::channels');
$routes->group('report', static function ($routes) {
    $routes->post('registerlistsbydate', 'api\Report::registerByDate');
    $routes->post('registerlistsbycnt', 'api\Report::depositTimes');
    $routes->post('registerlistsbycode', 'api\Report::registerByCode');
});
