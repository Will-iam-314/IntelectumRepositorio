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
    $routes->get('mistramites','Solicitante::getViewTramites'); 
    $routes->get('solicitud','Solicitante::getViewNuevaSolicitud');

    $routes->get('detalleTramite/(:segment)','Solicitante::getViewDetalleTramite/$1');

    //RUTAS PARA ARCHIVOS
    $routes->get('documentos/verTesis/(:segment)', 'Tramites::verFileTesis/$1');
    $routes->get('documentos/verDeclaracionJurada/(:segment)', 'Tramites::verFileDJ/$1');
    $routes->get('documentos/verAutorizacionPublicacion/(:segment)', 'Tramites::verFileAP/$1');

    $routes->post('nuevaSoli','Solicitante::nuevaSolicitud');
}); 

$routes->group('admin',['filter'=>'administrador'], function($routes){

    $routes->get('home','Administrador::index');

});

$routes->group('inspector',['filter'=>'inspector'], function($routes){

    $routes->get('home','Inspector::index');

});
 
