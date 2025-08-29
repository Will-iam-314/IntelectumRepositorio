<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::getViewlogin');
$routes->get('registro','Auth::getViewregistro');
