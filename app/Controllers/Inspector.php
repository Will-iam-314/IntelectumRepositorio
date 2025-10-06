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


    public function generatePaquetePublicacion($codigoTramite){
        $tramiteModel = new TramiteModel();
        $datosTramite = $tramiteModel->getTramite($codigoTramite);
       


        // Ruta donde se va a crear el directorio
        $directorio =WRITEPATH . "paquetes_temp/ITEM_1";
 
        //Crear el directorio si no existe
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        // Función para añadir un <dcvalue>
        function addDcValue($dom, $parent, $text, $attrs = []) {
            $dcvalue = $dom->createElement("dcvalue", $text);
            foreach ($attrs as $k => $v) {
                $dcvalue->setAttribute($k, $v);
            }
            $parent->appendChild($dcvalue);
        }
         


        /**
         * =====================================================
         * 1. CREAR dublin_core.xml
         * =====================================================
        */
        
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true; // Para que quede bonito

        $dublin = $dom->createElement("dublin_core");
        $dom->appendChild($dublin);

        

        // Agregar nodos
        addDcValue($dom, $dublin, "Solicitud URL", ["element" => "identifier", "qualifier" => "other", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "Mas info repositorio@unu.edu.pe", ["element" => "description", "language" => ""]);
        
        if (!empty($datosTramite['autores']) && is_array($datosTramite['autores'])) {
            foreach ($datosTramite['autores'] as $autor) {
                $nombreCompleto = $autor['nombre'];
                addDcValue($dom, $dublin, $nombreCompleto, [
                    "element" => "contributor",
                    "qualifier" => "author",
                    "language" => "es_PE"
                ]);
            }
        }

        addDcValue($dom, $dublin, $datosTramite['tituloMaterial'], ["element" => "title", "language" => "es_PE"]);
        addDcValue($dom, $dublin, date("Y", strtotime($datosTramite['fechaSustentacion'])), ["element" => "date", "qualifier" => "issued", "language" => "es_PE"]);
        addDcValue($dom, $dublin, $datosTramite['Asesor'], ["element" => "contributor", "qualifier" => "advisor", "language" => "es_PE"]);
        addDcValue($dom, $dublin, $datosTramite['resumenTesis'], ["element" => "description", "qualifier" => "abstract", "language" => "es_PE"]);
        
        if (!empty($datosTramite['palabrasclaveTesis']) && is_array($datosTramite['palabrasclaveTesis'])) {
            foreach ($datosTramite['palabrasclaveTesis'] as $palabraClave) {
                $palabrasclaves = $palabraClave;
                addDcValue($dom, $dublin,  $palabrasclaves, [
                    "element" => "subject",
                    "language" => "es_PE"
                ]);
            }
        }

     
        addDcValue($dom, $dublin, $datosTramite['lineaInvestigacion'], ["element" => "subject", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "spa", ["element" => "language", "qualifier" => "iso", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "PE", ["element" => "publisher", "qualifier" => "country"]);
        addDcValue($dom, $dublin, "Universidad Nacional de Ucayali", ["element" => "publisher", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "https://creativecommons.org/licenses/by/4.0/", ["element" => "rights", "qualifier" => "uri"]);
        addDcValue($dom, $dublin, "info:eu-repo/semantics/openAccess", ["element" => "rights", "language" => "en_US"]);
        addDcValue($dom, $dublin, "Universidad Nacional de Ucayali", ["element" => "source", "language" => "es_PE"]);
        addDcValue($dom, $dublin, "Repositorio institucional - UNU", ["element" => "source", "language" => "es_PE"]);
        addDcValue($dom, $dublin, $datosTramite['campoInvestigacion'], ["element" => "subject", "qualifier" => "ocde"]);

        if($datosTramite['GradoAcademicoOptar'] == 'titulo profesional'){
            addDcValue($dom, $dublin, "info:eu-repo/semantics/bachelorThesis", ["element" => "type", "language" => "es_PE"]);
        }

        if($datosTramite['GradoAcademicoOptar'] == 'segunda especialidad'){
            addDcValue($dom, $dublin, "info:eu-repo/semantics/bachelorThesis", ["element" => "type", "language" => "es_PE"]);   
        }

        if($datosTramite['GradoAcademicoOptar'] == 'maestria'){
            addDcValue($dom, $dublin, "info:eu-repo/semantics/masterThesis", ["element" => "type", "language" => "es_PE"]);      
        }

        if($datosTramite['GradoAcademicoOptar'] == 'doctorado'){
            addDcValue($dom, $dublin, "info:eu-repo/semantics/doctoralThesis", ["element" => "type", "language" => "es_PE"]);
        }

       

        // Guardar el XML del dublin_core en ITEM_1
        $dom->save($directorio . '/dublin_core.xml');

        /**
         * =====================================================
         * 2. CREAR metadata_renati.xml
         * =====================================================
        **/

        $domRenati = new \DOMDocument('1.0', 'UTF-8');
        $domRenati->formatOutput = true;

        $dublinRenati = $domRenati->createElement("dublin_core");
        $dublinRenati->setAttribute("schema", "renati");
        $domRenati->appendChild($dublinRenati);
        
        // Agregar nodos
        addDcValue($domRenati, $dublinRenati, $datosTramite['dniAsesor'], ["element" => "advisor", "qualifier" => "dni"]);
        addDcValue($domRenati, $dublinRenati, $datosTramite['orcidAsesor'], ["element" => "advisor", "qualifier" => "orcid"]);

        if (!empty($datosTramite['autores']) && is_array($datosTramite['autores'])) {
            foreach ($datosTramite['autores'] as $autor) {
                if (!empty($autor['dni'])) {
                    addDcValue($domRenati, $dublinRenati, $autor['dni'], ["element" => "author", "qualifier" => "dni"]);
                }
            }
        }

        addDcValue($domRenati, $dublinRenati, $datosTramite['campoAplicacion'], ["element" => "discipline"]);

        // Nivel académico (según el grado)
        switch (strtolower($datosTramite['GradoAcademicoOptar'])) {
            case 'titulo profesional':
                $nivel = "https://purl.org/pe-repo/renati/level#tituloProfesional";
                break;
            case 'segunda especialidad':
                $nivel = "	https://purl.org/pe-repo/renati/level#tituloSegundaEspecialidad";
                break;
            case 'maestria':
                $nivel = "https://purl.org/pe-repo/renati/level#maestro";
                break;
            case 'doctorado':
                $nivel = "https://purl.org/pe-repo/renati/level#doctor";
                break;
            default:
                $nivel = "";
        }

        addDcValue($domRenati, $dublinRenati, $nivel, ["element" => "level"]);

        addDcValue($domRenati, $dublinRenati, "https://purl.org/pe-repo/renati/type#tesis", ["element" => "type"]);

     
        addDcValue($domRenati, $dublinRenati, $datosTramite['Jurado1'], ["element" => "juror"]);
        addDcValue($domRenati, $dublinRenati, $datosTramite['Jurado2'], ["element" => "juror"]);
        addDcValue($domRenati, $dublinRenati, $datosTramite['Jurado3'], ["element" => "juror"]);

        $domRenati->save($directorio . '/metadata_renati.xml');

        /**
         * =====================================================
         * 3. CREAR metadata_thesis.xml
         * =====================================================
        **/

        $domThesis = new \DOMDocument('1.0', 'UTF-8');
        $domThesis->formatOutput = true;

        $dublinThesis = $domThesis->createElement("dublin_core");
        $dublinThesis->setAttribute("schema", "thesis");
        $domThesis->appendChild($dublinThesis);

        // Agregar nodos
        addDcValue($domThesis, $dublinThesis, "Universidad Nacional de Ucayali. Facultad de ". $datosTramite['solicitanteFacultad'], ["element" => "degree", "qualifier" => "grantor","language"=>"es_PE"]);
        addDcValue($domThesis, $dublinThesis, $datosTramite['lineaInvestigacion'], ["element" => "degree", "qualifier" => "discipline","language"=>"es_PE"]);
        addDcValue($domThesis, $dublinThesis, $datosTramite['GradoAcademicoOptar'], ["element" => "degree", "qualifier" => "name","language"=>"es_PE"]);

        $domThesis->save($directorio . '/metadata_thesis.xml');

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
