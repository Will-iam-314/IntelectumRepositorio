<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TramiteModel;
use App\Models\HistorialTramitesModel;

class DpiAdmin extends BaseController
{
    public function index()
    {
        return view('dpi/home');
    }

    public function getViewSolicitudes(){
        $tramitesModel = new TramiteModel();
        $historialModel = new HistorialTramitesModel();

        $dataTramite = $tramitesModel->getTramites();


        return view('dpi/Solicitudes', ['tramites' => $dataTramite]);

    }

    public function generarConstancia(){
        
    }
}
