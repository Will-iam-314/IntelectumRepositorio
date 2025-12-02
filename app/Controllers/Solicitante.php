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

    public function getViewTemporal(){
        return view('Auth/recuperacionExitosaPassword');
    }

    public function getTutorial(){
        return view('others/tutorial');
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

    public function getViewConstancias(){
        $tramiteModel = new TramiteModel();
        $datosTramites = $tramiteModel->getTramitesSolicitante(session('datarol_id'));

        $tramitesConConstancia=[];
        foreach($datosTramites as $tramites){
            if($tramites['estado'] == 'Constancia Emitida'){
                $tramitesConConstancia[] = $tramites;
            }
            
        }

        return view('Solicitante/Constancias',['tramites'=>$tramitesConConstancia]);
    }

    public function getViewNuevaSolicitud(){
        $lineaModel = new LineasInvestigacionModel();
        //$docenteModel = new DocentesModel();

        //agregar datos del solicitante
        $solicitante = $this->solicitanteModel->getSolicitante(session('id'));
    
        $nombreSolicitanteActual = $solicitante['apellidos_solicitante'] . ' ' . $solicitante['nombres_solicitante'] ;
        $dniSolicitanteActual = $solicitante['dni_solicitante'];

        $data = [
            
            'solicitanteActualNombres' => $nombreSolicitanteActual,
            'solicitanteActualDNI' => $dniSolicitanteActual,
         // 'lineas' => $lineaModel->findAll()
        ];
 
        return view('Solicitante/NuevaSolicitud', $data);
    }

    public function getViewDetalleTramite($codigoTramite){
        $tramiteModel = new TramiteModel();
        $estadosTramite = new EstadosTramitesModel();

        $datosTramite = $tramiteModel->getTramite($codigoTramite);
        $estados = $estadosTramite->getAllEstadosTramites();
        $etapas = array_column($estados,'nombres_estadotramite'); 

        if($datosTramite){
            return view('Solicitante/DetalleTramite',['tramite'=> $datosTramite,'etapas'=>$etapas] );
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
            'tituloTesis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El título de la tesis es obligatorio.'
                ]
            ],
            'resumenTesis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El resumen de la tesis es obligatorio.'
                ]
            ],
            'keywordsTesis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes ingresar al menos una palabra clave.'
                ]
            ],
            'lineaInvestigacion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe seleccionar una línea de investigación.'
                ]
            ],
            'CampoInvestigacion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe seleccionar un campo de investigación.'
                ]
            ],
            'CampoAplicacion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe seleccionar un campo de aplicación.'
                ]
            ],
            'FechaSustentacion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe ingresar la fecha de sustentación.'
                ]
            ],
            'TesisFile' => [
                'rules' => 'uploaded[TesisFile]|max_size[TesisFile,51200]|ext_in[TesisFile,pdf]',
                'errors' => [
                    'uploaded' => 'Debe subir el archivo de la tesis.',
                    'max_size' => 'El archivo de la tesis no debe superar los 50 MB.',
                    'ext_in' => 'El archivo de la tesis debe ser PDF.'
                ]
            ],
            'gradoTipo' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe seleccionar el tipo de grado.'
                ]
            ],
            'gradoDescripcion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe ingresar la descripción del grado.'
                ]
            ],
            'Asesor' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe ingresar el nombre del asesor.'
                ]
            ],
            'AsesorDNI' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe ingresar el DNI del asesor.'
                ]
            ],
            'AsesorORCID' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe ingresar el ORCID del asesor.'
                ]
            ],
            'PresidenteJurado' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe ingresar al Presidente del Jurado.'
                ]
            ],
            'PrimerMiembroJurado' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe ingresar al Primer Miembro del Jurado.'
                ]
            ],
            'SegundoMiembroJurado' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe ingresar al Segundo Miembro del Jurado.'
                ]
            ],
            'DeclaracionJuradaFile' => [
                'rules' => 'uploaded[DeclaracionJuradaFile]|max_size[DeclaracionJuradaFile,2048]|ext_in[DeclaracionJuradaFile,pdf]',
                'errors' => [
                    'uploaded' => 'Debe subir la Declaración Jurada.',
                    'max_size' => 'La Declaración Jurada no debe pesar más de 2 MB.',
                    'ext_in' => 'La Declaración Jurada debe estar en PDF.'
                ]
            ],
            'AutorizaciónPublicacioFile' => [
                'rules' => 'uploaded[AutorizaciónPublicacioFile]|max_size[AutorizaciónPublicacioFile,2048]|ext_in[AutorizaciónPublicacioFile,pdf]',
                'errors' => [
                    'uploaded' => 'Debe subir la Autorización de Publicación.',
                    'max_size' => 'La Autorización de Publicación no debe pesar más de 2 MB.',
                    'ext_in' => 'La Autorización de Publicación debe estar en PDF.'
                ]
            ],
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

        //PASAR DATOS A MAYUCULAS
        $post['tituloTesis'] = mb_strtoupper($post['tituloTesis']);
        foreach($post['autores'] as $key=>$autor){
           $post['autores'][$key]['nombre'] = mb_strtoupper($autor['nombre'], 'UTF-8');
        }
        $post['Asesor'] = mb_strtoupper($post['Asesor']);
        $post['PresidenteJurado']= mb_strtoupper($post['PresidenteJurado']);
        $post['PrimerMiembroJurado']= mb_strtoupper($post['PrimerMiembroJurado']);
        $post['SegundoMiembroJurado']= mb_strtoupper($post['SegundoMiembroJurado']);

        
        
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