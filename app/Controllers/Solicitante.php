<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Controllers\Tramites;

use App\Models\LineasInvestigacionModel;
use App\Models\DocentesModel;
use App\Models\SolicitantesModel;
use App\Models\TramiteModel;


class Solicitante extends BaseController
{

    protected $solicitanteModel;

    public function __construct()
    {
        $this->solicitanteModel = new SolicitantesModel();
    }

    public function index()
    {
        return view('Solicitante/home');
    }

    public function getViewTramites(){
        $tramiteModel = new TramiteModel();
        $datosTramites = $tramiteModel->getTramitesSolicitante(session('datarol_id'));
        if($datosTramites){
            return view('Solicitante/MisTramites',['tramites'=> $datosTramites] );
        }
        
    } 

    public function getViewNuevaSolicitud(){
        $lineaModel = new LineasInvestigacionModel();
        $docenteModel = new DocentesModel();

        $data = [
            'docentes' => $docenteModel->findAll(),
            'lineas' => $lineaModel->findAll()
        ];
 
        return view('Solicitante/NuevaSolicitud', $data);
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
        $solicitante = $this->solicitanteModel->getSolicitante(session('id_usuario'));
        $post['idsolicitante'] = $solicitante[0]['id_solicitante'];
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
}

?>