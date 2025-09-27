<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TramiteModel;
use App\Models\HistorialTramitesModel;
use App\Models\MaterialRevisionesModel;

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

    public function getViewInspeccionObservaciones($codigoTramite){
        $tramiteModel = new TramiteModel();
        $datosTramite = $tramiteModel->getObservacionesTramite($codigoTramite);

        if($datosTramite){   
            
            return view('Inspector/inspeccion',$datosTramite);
        }
        
        
       
    }

    

    public function registrarRevision($idMaterial,$codigoTramite){

        $tramiteModel = new TramiteModel();
        $datosTramite = $tramiteModel->getTramite($codigoTramite);

        $post = $this->request->getPost(); 
        $idInspector =null ;
        $idAdmin = null;
        $observaciones = null;
        $estadoRevision = 2;
       
        if(session('rol') == 'inspector'){
            $idInspector = session('datarol_id');
        }

        if(session('rol')=='administrador'){
            $idAdmin = session('datarol_id');
        }

        if(isset($post['observaciones'])){
            $observaciones = $post['observaciones'];
        }

        if(isset($post['tiene_observaciones']) && $post['tiene_observaciones'] == 'on'){
            $estadoRevision = 1;
        }

        

        $datos = [
            'idInspector' => $idInspector,
            'idAdmin' => $idAdmin,
            'idMaterial' => $idMaterial,
            'observaciones'=> $observaciones,
            'estadoRevision' => $estadoRevision
        ];

        $materiaRevisionModel = new MaterialRevisionesModel();
        $registroRevision = $materiaRevisionModel->newRevision($datos);
        if($registroRevision){
            $historialModel = new HistorialTramitesModel();

            if($observaciones){
                $historialModel->newHistorialTramite(session('id'),$datosTramite['idTramite'],session('rol'),3);
                $tramiteModel->updateEstado($datosTramite['idTramite'],3);

                return redirect()->to('inspector/solicitudes')->with('success', 'Inspección registrada con observaciones correctamente');

            }else{
                $historialModel->newHistorialTramite(session('id'),$datosTramite['idTramite'],session('rol'),5);
                $tramiteModel->updateEstado($datosTramite['idTramite'],5);

                return redirect()->to('inspector/solicitudes')->with('success', 'Inspección material aprobado correctamente');
            }

            
            
        }else{
            return redirect()->back()->withInput()->with('errors','Algo salio mal, no se pudo registrar la inspeccion');
        }

       
           
        
    }


    public function generateArchivesPublicacion(){

    }

   
}
