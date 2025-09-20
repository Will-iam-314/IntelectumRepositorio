<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TramiteModel;
use App\Models\HistorialTramitesModel;

class Inspector extends BaseController
{
    public function index()
    {
       

        return view('inspector/home');
    }

    public function getViewSolicitudes(){
        $tramitesModel = new TramiteModel();
        $historialModel = new HistorialTramitesModel();

        $dataTramite = $tramitesModel->getTramites();

        foreach($dataTramite as &$tramite){
            $idTramite = $tramite['idTramite'];
            $tramite['inspectorAsignado'] = $historialModel->validateInspectorAsignation($idTramite, session('id'));
        }
        unset($tramite);

        return view('inspector/Solicitudes', ['tramites' => $dataTramite]);

    }

    public function getViewInspeccion($codigoTramite,$continuaInspeccion){
        $tramiteModel = new TramiteModel();
        $datosTramite = $tramiteModel->getTramite($codigoTramite);
        if($continuaInspeccion == 1){
            if($datosTramite){   
                return view('Inspector/inspeccion',$datosTramite);
            }
        }else{
            if($datosTramite){
                $historialModel = new HistorialTramitesModel();
                $historialModel->newHistorialTramite(session('id'),$datosTramite['idTramite'],session('rol'),2);
                $tramiteModel->updateEstado($datosTramite['idTramite'],2);
                
                return view('Inspector/inspeccion',$datosTramite);
            }
        }
        

    }

   
}
