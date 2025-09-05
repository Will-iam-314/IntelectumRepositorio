<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Solicitante extends BaseController
{
    public function index()
    {
        return view('Solicitante/home');
    }

    public function getViewTramites(){
        return view('Solicitante/MisTramites');
    } 

    public function getViewNuevaSolicitud(){
        return view('Solicitante/NuevaSolicitud');
    }
}

?>