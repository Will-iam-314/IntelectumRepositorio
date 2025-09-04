<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::getViewlogin',['filter'=>'AuthRedirect']);
$routes->get('login','Auth::getViewlogin',['filter'=>'AuthRedirect']);
$routes->get('registrarse','Auth::getViewregistro',['filter'=>'AuthRedirect']);
$routes->get('verificar','Auth::getViewVerificacion',['filter'=>'AuthRedirect']);
$routes->get('logout','Auth::logout');

$routes->post('registro','Users::nuevoUsuario');
$routes->post('verificacion','Users::verificarUsuario');
$routes->post('auth','Auth::authentication');


$routes->group('solicitante',['filter'=>'solicitante'], function($routes){
    $routes->get('home','Solicitante::index');
}); 
