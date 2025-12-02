<?php

use CodeIgniter\Router\RouteCollection;
 
/**
 * @var RouteCollection $routes
 */
$routes->get('temporalView','Solicitante::getViewTemporal');

$routes->get('videoTutorial','Solicitante::getTutorial');

$routes->get('/', 'Auth::getViewlogin',['filter'=>'AuthRedirect']);
$routes->get('login','Auth::getViewlogin',['filter'=>'AuthRedirect']);
$routes->get('registrarse','Auth::getViewregistro',['filter'=>'AuthRedirect']);
$routes->get('verificar','Auth::getViewVerificacion',['filter'=>'AuthRedirect']);
$routes->get('recuperarPass','Auth::getViewRecuperarPassword',['filter'=>'AuthRedirect']);
$routes->get('verificarRecuperacion','Auth::getViewValCodigoRecuperacionPassword',['filter'=>'AuthRedirect']);
$routes->get('logout','Auth::logout');

$routes->post('registro','Users::nuevoUsuario');
$routes->post('verificacion','Users::verificarUsuario');

$routes->post('recuperarPassword','Users::recuperarPass');
$routes->post('verificarRecuperacion','Users::validarCodigoRecuperacionPass');
$routes->post('actualizarPassword/(:num)','Users::actualizarPass/$1');

$routes->post('auth','Auth::authentication');
 

 
$routes->group('solicitante',['filter'=>'solicitante'], function($routes){
    $routes->get('home','Solicitante::index');
    $routes->get('mistramites','Solicitante::getViewTramites'); 
    $routes->get('solicitud','Solicitante::getViewNuevaSolicitud');
    $routes->get('detalleTramite/(:segment)','Solicitante::getViewDetalleTramite/$1');

    $routes->get('observaciones/(:segment)','Solicitante::getViewObservaciones/$1');

    $routes->get('constancias','Solicitante::getViewConstancias');

    $routes->post('nuevaSoli','Solicitante::nuevaSolicitud');
    $routes->post('levantarObservaciones','Solicitante::levantarObservaciones');


    //RUTAS PARA ARCHIVOS
    $routes->get('documentos/verTesis/(:segment)', 'Tramites::verFileTesis/$1');
    $routes->get('documentos/verDeclaracionJurada/(:segment)', 'Tramites::verFileDJ/$1');
    $routes->get('documentos/verAutorizacionPublicacion/(:segment)', 'Tramites::verFileAP/$1');
}); 

$routes->group('admin',['filter'=>'administrador'], function($routes){

    $routes->get('home','Administrador::index');

});

$routes->group('inspector',['filter'=>'inspector'], function($routes){   

    $routes->get('home','Inspector::index');
    $routes->get('solicitudes','Inspector::getViewSolicitudes');

    $routes->get('inspeccion/(:segment)/(:num)','Inspector::getViewInspeccion/$1/$2'); 
    $routes->get('inspeccionObservaciones/(:segment)/(:num)','Inspector::getViewInspeccionObservaciones/$1/$2'); 

    $routes->get('publicacion/(:num)/(:segment)','Inspector::getViewPublicacion/$1/$2');
    $routes->get('downloadPaquete/(:segment)','Inspector::generatePaquetePublicacion/$1');
    

    $routes->post('nuevaInspeccion/(:num)/(:segment)','Inspector::registrarRevision/$1/$2');
    $routes->post('registrarURLpubliacion/(:num)','Inspector::registrarPublicacion/$1');

    //RUTAS PARA ARCHIVOS
    $routes->get('documentos/verTesis/(:segment)', 'Tramites::verFileTesis/$1');
    $routes->get('documentos/verDeclaracionJurada/(:segment)', 'Tramites::verFileDJ/$1');
    $routes->get('documentos/verAutorizacionPublicacion/(:segment)', 'Tramites::verFileAP/$1');

});

$routes->group('dpi',['filter'=>'dpi'], function($routes){

    $routes->get('home','DpiAdmin::index');
    $routes->get('solicitudes','DpiAdmin::getViewSolicitudes');
    $routes->get('generarConstancia/(:segment)','DpiAdmin::generarConstancia/$1');

    $routes->get('enviarConstancia/(:segment)/(:segment)','DpiAdmin::enviarConstancia/$1/$2');
    $routes->get('verConstancia/(:segment)','DpiAdmin::getViewConstancia/$1');
   

});

$routes->get('Constancia/(:segment)','DpiAdmin::verConstancia/$1');
 
