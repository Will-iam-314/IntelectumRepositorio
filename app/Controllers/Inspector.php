<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TramiteModel;

class Inspector extends BaseController
{
    public function index()
    {
       

        return view('inspector/home');
    }

    public function getViewSolicitudes(){
        $tramitesModel = new TramiteModel();
        $dataTramite = $tramitesModel->getTramites();

        return view('inspector/Solicitudes', ['tramites' => $dataTramite]);

    }

    public function getViewInspeccion($codigoTramite){
        $tramiteModel = new TramiteModel();
        $datosTramite = $tramiteModel->getTramite($codigoTramite);
        if($datosTramite){
            return view('Inspector/inspeccion',$datosTramite);
        }

    }
}
