<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Controllers\Tramites;

use App\Models\LineasInvestigacionModel;
use App\Models\DocentesModel;
use App\Models\SolicitantesModel;
use App\Models\TramiteModel;
use App\Models\EstadosTramitesModel;
use App\Models\HistorialTramitesModel;


class Solicitante extends BaseController
{

    protected $solicitanteModel;

    public function __construct()
    {
        $this->solicitanteModel = new SolicitantesModel();
    }

    public function index()

    {
        $tramiteModel = new TramiteModel();
        $estadosTramite = new EstadosTramitesModel();

        $datosTramites = $tramiteModel->getLastTramiteSolicitante(session('datarol_id'));
        $estados = $estadosTramite->getAllEstadosTramites();

        $etapas = array_column($estados,'nombres_estadotramite');
    
        
        if($datosTramites){
            return view('Solicitante/home',['tramite'=> $datosTramites,'etapas'=>$etapas] );
        }else{
            return view('Solicitante/home');
        }
        
    }

    public function getViewTramites(){
        $tramiteModel = new TramiteModel();
        $datosTramites = $tramiteModel->getTramitesSolicitante(session('datarol_id'));
        if($datosTramites){
            return view('Solicitante/MisTramites',['tramites'=> $datosTramites] );
        }else{
            return view('Solicitante/MisTramites');
        }
        
    } 

    public function getViewNuevaSolicitud(){
        $lineaModel = new LineasInvestigacionModel();
        //$docenteModel = new DocentesModel();

        //agregar datos del solicitante
        $solicitante = $this->solicitanteModel->getSolicitante(session('id'));
    
        $nombreSolicitanteActual = $solicitante['nombres_solicitante'] . ' ' . $solicitante['apellidos_solicitante'] ;
        $dniSolicitanteActual = $solicitante['dni_solicitante'];

        $data = [
            
            'solicitanteActualNombres' => $nombreSolicitanteActual,
            'solicitanteActualDNI' => $dniSolicitanteActual,
            'lineas' => $lineaModel->findAll()
        ];
 
        return view('Solicitante/NuevaSolicitud', $data);
    }

    public function getViewDetalleTramite($codigoTramite){
        $tramiteModel = new TramiteModel();
        $datosTramite = $tramiteModel->getTramite($codigoTramite);
        if($datosTramite){
            return view('Solicitante/DetalleTramite',$datosTramite);
        }
    }

    public function getViewObservaciones($codigoTramite){
        $tramiteModel = new TramiteModel();
        $datosTramite = $tramiteModel->getObservacionesTramite($codigoTramite);
        if($datosTramite){
            return view('Solicitante/observaciones',$datosTramite);
        }
    }


    public function nuevaSolicitud(){

        $rules = [
            'tituloTesis' => 'required',
            'resumenTesis' => 'required',
            'keywordsTesis' => 'required',
            'lineaInvestigacion' => 'required',
            'CampoInvestigacion' => 'required',
            'CampoAplicacion'=>'required',
            'FechaSustentacion' => 'required',
            'TesisFile' => 'uploaded[TesisFile]|max_size[TesisFile,10240]|ext_in[TesisFile,pdf]',
            'Asesor' => 'required',
            'AsesorDNI' => 'required',
            'AsesorORCID' => 'required',
            'PresidenteJurado' => 'required',
            'PrimerMiembroJurado' => 'required',
            'SegundoMiembroJurado' => 'required',
            'DeclaracionJuradaFile' => 'uploaded[DeclaracionJuradaFile]|max_size[DeclaracionJuradaFile,2048]|ext_in[DeclaracionJuradaFile,pdf]',
            'AutorizaciónPublicacioFile' => 'uploaded[AutorizaciónPublicacioFile]|max_size[AutorizaciónPublicacioFile,2048]|ext_in[AutorizaciónPublicacioFile,pdf]'

        ];

        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('errors',$this->validator->listErrors());
        }

        $post = $this->request->getPost(); 
        $solicitante = $this->solicitanteModel->getSolicitante(session('id'));
        $post['idsolicitante'] = $solicitante['id_solicitante'];
        $fileTesis = $this->request->getFile('TesisFile');
        $fileDJ = $this->request->getFile('DeclaracionJuradaFile');
        $fileAutorizacionPublicacion = $this->request->getFile('AutorizaciónPublicacioFile');
        
        $tramiteController = new Tramites();

        $boolNuevoTramite= $tramiteController->nuevoTramite($post,$fileTesis,$fileDJ,$fileAutorizacionPublicacion);

        if($boolNuevoTramite){
            return redirect()->to(base_url('solicitante/mistramites'));
        }else{
            return redirect()->back()->withInput()->with('errors','Algo salio mal, no se pudo enviar la solicitud');
        }
        

    }

    public function levantarObservaciones(){
        $post = $this->request->getPost(); 
        $files = service('request')->getFiles();

        $tramiteModel = new TramiteModel();
        $levantarObservaciones  = $tramiteModel->updateTramiteObservacion($post,$files);

        $historialModel = new HistorialTramitesModel();
        if($levantarObservaciones){
            $tramiteModel->updateEstado($post['idTramite'],4);
            $historialModel->newHistorialTramite(session('id'),$post['idTramite'],session('rol'),4);
            return redirect()->to('solicitante/mistramites')->with('success', 'Correciones enviadas');
        }else{
            return redirect()->back()->withInput()->with('errors','Algo salio mal, no se pudo enviar las correciones');
        }
    }
}

?>