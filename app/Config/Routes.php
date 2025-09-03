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

$routes->post('auth','Auth::authentication');
$routes->get('logout','Auth::logout');

$routes->group('solicitante',['filter'=>'solicitante'], function($routes){
    $routes->get('home','Solicitante::index');
});
