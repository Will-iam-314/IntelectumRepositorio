<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::getViewlogin');
$routes->get('registrarse','Auth::getViewregistro');
$routes->post('registro','Users::nuevoUsuario');
$routes->post('verificacion','Users::verificarUsuario');

$routes->get('verificar','Auth::getViewVerificacion');
