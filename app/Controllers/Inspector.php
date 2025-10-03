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

    public function getViewPublicacion($idTramite,$codigoTramite){
        
        $data = [
            'idTramite' => $idTramite,
            'codigoTramite' => $codigoTramite
        ];

        return view('Inspector/publicacion',$data);
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


    public function generatePaquetePublicacion($idTramite){
        // Ruta donde se va a crear el directorio
        $directorio =WRITEPATH . "paquetes_temp/ITEM_1";
 
        // 1. Crear el directorio si no existe
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        // 2. Generar XML del dublin_core
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true; // Para que quede bonito

        $dublin = $dom->createElement("dublin_core");
        $dom->appendChild($dublin);

        // Función para añadir un <dcvalue>
        function addDcValue($dom, $parent, $text, $attrs = []) {
            $dcvalue = $dom->createElement("dcvalue", $text);
            foreach ($attrs as $k => $v) {
                $dcvalue->setAttribute($k, $v);
            }
            $parent->appendChild($dcvalue);
        }

        // Agregar nodos
        addDcValue($dom, $dublin, "Solicitud URL", ["element" => "identifier", "qualifier" => "other", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "Mas info repositorio@unu.edu.pe", ["element" => "description", "language" => ""]);
        addDcValue($dom, $dublin, "Mayta Rodríguez, Lesly Lucero", ["element" => "contributor", "qualifier" => "author", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "Pérez Nolorve, Erick", ["element" => "contributor", "qualifier" => "author", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "Modelo de gobernanza basado en BPM para mejorar la gestión de servicios en el grupo Uranio SAC", ["element" => "title", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "2025", ["element" => "date", "qualifier" => "issued", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "Ferrari Fernández, Freddy Elar", ["element" => "contributor", "qualifier" => "advisor", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "La presea an principios de goados esperados incl.", ["element" => "description", "qualifier" => "abstract", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "BPM", ["element" => "subject", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "Gestión", ["element" => "subject", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "Servicios", ["element" => "subject", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "Gestión de Tecnologías de Información", ["element" => "subject", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "spa", ["element" => "language", "qualifier" => "iso", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "PE", ["element" => "publisher", "qualifier" => "country"]);
        addDcValue($dom, $dublin, "Universidad Nacional de Ucayali", ["element" => "publisher", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "https://creativecommons.org/licenses/by/4.0/", ["element" => "rights", "qualifier" => "uri"]);
        addDcValue($dom, $dublin, "info:eu-repo/semantics/openAccess", ["element" => "rights", "language" => "en_US"]);
        addDcValue($dom, $dublin, "Universidad Nacional de Ucayali", ["element" => "source", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "Repositorio institucional - UNU", ["element" => "source", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "https://purl.org/pe-repo/ocde/ford#2.02.04", ["element" => "subject", "qualifier" => "ocde"]);
        addDcValue($dom, $dublin, "info:eu-repo/semantics/bachelorThesis", ["element" => "type", "language" => "es_PE"]);


        // Guardar el XML del dublin_core en ITEM_1
        $dom->save($directorio . '/dublin_core.xml');

        // 3. Crear el ZIP
        $zipPath = WRITEPATH . 'paquetes_temp/ITEM_1.zip';
        $zip = new \ZipArchive();

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            $archivos = scandir($directorio);
            foreach ($archivos as $archivo) {
                if ($archivo != "." && $archivo != "..") {
                    $zip->addFile($directorio . "/" . $archivo, $archivo);
                }
            }
            $zip->close();
        } else {
            return "Error al crear el ZIP.";
        }

        // 4. Descargar el ZIP
        return $this->response->download($zipPath, null)->setFileName("ITEM_1.zip");
    }

    public function registrarPublicacion($idTramite){
        $tramiteModel = new TramiteModel();
        $post = $this->request->getPost(); 

        $response = $tramiteModel->saveURLpublicacion($idTramite,$post['urlPublicacion']);

        if($response){   

            $historialModel = new HistorialTramitesModel();

            $historialModel->newHistorialTramite(session('id'),$idTramite,session('rol'),6);
            $tramiteModel->updateEstado($idTramite,6);

            return redirect()->to('inspector/solicitudes')->with('success', 'URL de publicacion registrado Correctamente');

        }else{
            return redirect()->back()->withInput()->with('errors','Algo salio mal, no se pudo registrar el URL de publicacion');
        }
        
        
    }

   
}
