<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\MaterialModel;
use App\Models\TesisModel;
use App\Models\MaterialRevisionesModel;


class TramiteModel extends Model
{
    protected $table            = 'tramites';
    protected $primaryKey       = 'id_tramite';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        'codigo_tramite',
        'declaracionJurada_tramite',
        'autorizacionPublicacion_tramite',
        'id_estadotramite_tramite',
        'id_solicitante_tramite',
        'id_materia_tramite',
        'urlpublicacion_tramite'

    ];

    
    // Dates
    protected $useTimestamps = false;
    protected $createdField  = 'date_created_tramite';
    protected $updatedField  = 'date_updated_tramite';
    
  
    public function newTramite($data,$fileT,$fileDJ,$fileAP){

        try{


            $materialModel = new MaterialModel();
            $idMaterialModel = $materialModel->newMaterial($data,$fileT);

            if($idMaterialModel){
                
                $idnewTramite = $this->insert([
                'codigo_tramite'=> $this->generaCodigo(),
                'declaracionJurada_tramite' => $fileDJ,
                'autorizacionPublicacion_tramite' => $fileAP,
                'id_estadotramite_tramite'=> 1,
                'id_solicitante_tramite' => $data['idsolicitante'],
                'id_materia_tramite' => $idMaterialModel
                ]);

                return $idnewTramite;
            }else{
                return false;
            }


        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }
    }

    public function generaCodigo(){
        $anio = date('y');

        $ultimo = $this->select('codigo_tramite')->orderBy('id_tramite','DESC')->first();

        if($ultimo){
            // Extraer los 4 dígitos (del medio)
            $numero = (int) substr($ultimo['codigo_tramite'], 3, 4);
            $numero++;
        }else{
            // Primer registro del año
            $numero = 1;
        }

        // Rellenar con ceros a la izquierda
        $numeroFormateado = str_pad($numero, 4, '0', STR_PAD_LEFT);

        $newcode = "ITR".$numeroFormateado.$anio;
        return $newcode;
    }

    public function getTramitesSolicitante($idSolicitante){

        try{

      
            $tramites = $this->select('
                material.titulo_materia as titulo, 
                material.tipo_materia as tipomateria, 
                tramites.codigo_tramite as codigo, 
                tramites.date_created_tramite as fechapresentacion,
                estadotramites.nombres_estadotramite as estado
            ')
            ->join('material', 'material.id_materia = tramites.id_materia_tramite')
            ->join('estadotramites', 'estadotramites.id_estadotramite = tramites.id_estadotramite_tramite')
            ->where('tramites.id_solicitante_tramite', $idSolicitante)
            ->orderBy('id_tramite','DESC')
            ->findAll();
            
            return $tramites;

        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }
    }

    public function getLastTramiteSolicitante($idSolicitante){
        try{

      
            $tramites = $this->select('
                material.titulo_materia as titulo, 
                material.tipo_materia as tipomateria, 
                tramites.codigo_tramite as codigo, 
                tramites.date_created_tramite as fechapresentacion,
                estadotramites.nombres_estadotramite as estado
            ')
            ->join('material', 'material.id_materia = tramites.id_materia_tramite')
            ->join('estadotramites', 'estadotramites.id_estadotramite = tramites.id_estadotramite_tramite')
            ->where('tramites.id_solicitante_tramite', $idSolicitante)
            ->orderBy('id_tramite','DESC')
            ->first();
            
            if($tramites){
                return $tramites;
            }else{
                return false;
            }

        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }
    }

    public function getTramite($codigo){
        try{

    
            $tramites = $this->select('
                
                material.id_materia as idMaterial,
                material.titulo_materia as tituloMaterial, 
                material.tipo_materia as tipomateriaMaterial, 
                
                tesis.documento_tesi as fileTesis, 
                tesis.resumen_tesi as resumenTesis,
                tesis.palabrasclave_tesi as palabrasclaveTesis,
                
                asesor.nombres_docente as nombresAsesor,
                asesor.apellidos_docente as apellidosAsesor,

                jurado1.nombres_docente as nombresJurado1,
                jurado1.apellidos_docente as apellidosJurado1,

                jurado2.nombres_docente as nombresJurado2,
                jurado2.apellidos_docente as apellidosJurado2,

                jurado3.nombres_docente as nombresJurado3,
                jurado3.apellidos_docente as apellidosJurado3,

                tramites.id_tramite as idTramite,
                tramites.codigo_tramite as codigoTramite, 
                tramites.date_created_tramite as fechapresentacionTramite,
                tramites.declaracionJurada_tramite as fileDeclaracionJuradaTramite,
                tramites.autorizacionPublicacion_tramite as fileAutorizacionPublicacionTramite,

                estadotramites.nombres_estadotramite as estadoTramite,

                solicitantes.nombres_solicitante as solicitanteNombre,
                solicitantes.apellidos_solicitante as solicitanteApellido,
                solicitantes.dni_solicitante as solicitanteDNI,
                
                escuelas.nombre_escuela as solicitanteEscuela


            ')
            ->join('material', 'material.id_materia = tramites.id_materia_tramite')
            ->join('estadotramites', 'estadotramites.id_estadotramite = tramites.id_estadotramite_tramite')
            ->join('tesis','tesis.id_tesi = material.id_tesi_materia')
            ->join('solicitantes','solicitantes.id_solicitante = tramites.id_solicitante_tramite')
            ->join('escuelas','escuelas.id_escuela = solicitantes.id_escuela_solicitante')
            

            // joins con alias
            ->join('docentes asesor','asesor.id_docente = tesis.id_docente_asesor_tesi','left')
            ->join('docentes jurado1','jurado1.id_docente = tesis.id_docente_jurado1_tesi','left')
            ->join('docentes jurado2','jurado2.id_docente = tesis.id_docente_jurado2_tesi','left')
            ->join('docentes jurado3','jurado3.id_docente = tesis.id_docente_jurado3_tesi','left')

            ->where('tramites.codigo_tramite', $codigo)
            ->first();
            
            return $tramites;

        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }
    }

    public function getObservacionesTramite($codigo){
         try{

    
            $tramite = $this->select('
                
                material.id_materia as idMaterial,
                material.titulo_materia as tituloMaterial, 
                material.tipo_materia as tipomateriaMaterial, 
                
                tesis.id_tesi as idTesis,
                tesis.documento_tesi as fileTesis, 
                tesis.resumen_tesi as resumenTesis,
                tesis.palabrasclave_tesi as palabrasclaveTesis,
                
                asesor.nombres_docente as nombresAsesor,
                asesor.apellidos_docente as apellidosAsesor,

                jurado1.nombres_docente as nombresJurado1,
                jurado1.apellidos_docente as apellidosJurado1,

                jurado2.nombres_docente as nombresJurado2,
                jurado2.apellidos_docente as apellidosJurado2,

                jurado3.nombres_docente as nombresJurado3,
                jurado3.apellidos_docente as apellidosJurado3,

                tramites.id_tramite as idTramite,
                tramites.codigo_tramite as codigoTramite, 
                tramites.date_created_tramite as fechapresentacionTramite,
                tramites.declaracionJurada_tramite as fileDeclaracionJuradaTramite,
                tramites.autorizacionPublicacion_tramite as fileAutorizacionPublicacionTramite,

                estadotramites.nombres_estadotramite as estadoTramite,

                solicitantes.nombres_solicitante as solicitanteNombre,
                solicitantes.apellidos_solicitante as solicitanteApellido,
                solicitantes.dni_solicitante as solicitanteDNI,
                
                escuelas.nombre_escuela as solicitanteEscuela,


            ')
            ->join('material', 'material.id_materia = tramites.id_materia_tramite')
            ->join('estadotramites', 'estadotramites.id_estadotramite = tramites.id_estadotramite_tramite')
            ->join('tesis','tesis.id_tesi = material.id_tesi_materia')
            ->join('solicitantes','solicitantes.id_solicitante = tramites.id_solicitante_tramite')
            ->join('escuelas','escuelas.id_escuela = solicitantes.id_escuela_solicitante')
 
            
            // joins con alias
            ->join('docentes asesor','asesor.id_docente = tesis.id_docente_asesor_tesi','left')
            ->join('docentes jurado1','jurado1.id_docente = tesis.id_docente_jurado1_tesi','left')
            ->join('docentes jurado2','jurado2.id_docente = tesis.id_docente_jurado2_tesi','left')
            ->join('docentes jurado3','jurado3.id_docente = tesis.id_docente_jurado3_tesi','left')

            ->where('tramites.codigo_tramite', $codigo)
            ->first();

            $revisionMaterialModel = new MaterialRevisionesModel;
            $observaciones = $revisionMaterialModel->select('observacion_materiarevision as observaciones')
            ->where('id_materia_materiarevision' ,$tramite['idMaterial'])
            ->orderBy('id_materiarevision','DESC')
            ->first();

            $tramite['observaciones'] = $observaciones['observaciones'];
            
            return $tramite;

        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }
    }

    public function getTramites(){
        try{
            $tramites = $this->select('
                material.id_materia as idMaterial,
                material.titulo_materia as tituloMaterial, 
                material.tipo_materia as tipomateriaMaterial, 

                tramites.id_tramite as idTramite,
                tramites.codigo_tramite as codigoTramite, 
                tramites.date_created_tramite as fechapresentacionTramite,

                CONCAT(solicitantes.nombres_solicitante, " ", solicitantes.apellidos_solicitante) 
                as nombreCompletoSolicitante,

                estadotramites.nombres_estadotramite as estadoTramite
            ')
            ->join('material', 'material.id_materia = tramites.id_materia_tramite')
            ->join('estadotramites', 'estadotramites.id_estadotramite = tramites.id_estadotramite_tramite')
            ->join('solicitantes','solicitantes.id_solicitante = tramites.id_solicitante_tramite')
            ->orderBy('id_tramite','DESC')
            ->findAll();

            return $tramites;

        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }
    }

    public function updateEstado($idTramite, $idNuevoEstado){

        try{

            $this->update($idTramite,['id_estadotramite_tramite' => $idNuevoEstado]);

        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }

    }

    public function updateTramiteObservacion($data,$dataFiles){

        //validar si existen tambien en los datos, los que existan se actualizan los que no, no.
        $materialModel = new MaterialModel();
        $tesisModel = new TesisModel();

        if(isset($data["tituloMaterial"])){
            $materialModel->update($data['idMaterial'], ['titulo_materia' => $data["tituloMaterial"]] );
        }
        
        if(isset($data["resumenTesis"])){
            $tesisModel->update($data['idTesis'],['resumen_tesi' =>$data["resumenTesis"]]);
        }

        if(isset($data["palabrasClaveTesis"])){
            $tesisModel->update($data['idTesis'],['palabrasclave_tesi' =>$data["palabrasClaveTesis"]]);
        }

        // Archivo de Tesis
        if (isset($dataFiles['fileTesis']) && $dataFiles['fileTesis']->isValid() && !$dataFiles['fileTesis']->hasMoved()) {
            $nameFileTesis = 'TesisFile_'.$data['codigoTramite'].'.pdf'; 
            $rutaFileT = WRITEPATH . 'uploads/material/tesis/' . $nameFileTesis; 

            if(file_exists($rutaFileT)){
                unlink($rutaFileT);
            }

            $dataFiles['fileTesis']->move( WRITEPATH . 'uploads/material/tesis/',$nameFileTesis);
        }
        
        
        // Declaración Jurada
        if (isset($dataFiles['declaracionJurada']) && $dataFiles['declaracionJurada']->isValid() && !$dataFiles['declaracionJurada']->hasMoved()) {
            $nameFileDJ = 'DeclaracionJurada_'.$data['codigoTramite'].'.pdf';
            $rutaFileDJ = WRITEPATH . 'uploads/tramites/declaracionesJuradas/'.$nameFileDJ;
        
            if(file_exists($rutaFileDJ)){
                unlink($rutaFileDJ);
            }
            
            $dataFiles['declaracionJurada']->move(WRITEPATH . 'uploads/tramites/declaracionesJuradas/', $nameFileDJ);
        }

        // Autorización de Publicación
        if (isset($dataFiles['autorizacionPublicacion']) && $dataFiles['autorizacionPublicacion']->isValid() && !$dataFiles['autorizacionPublicacion']->hasMoved()) {
            $nameFileAP = 'DeclaracionJurada_'.$data['codigoTramite'].'.pdf';
            $rutaFileAP = WRITEPATH . 'uploads/tramites/autorizacionesPublicacion/'.$nameFileAP;
        
            if(file_exists( $rutaFileAP)){
                unlink( $rutaFileAP);
            }

            $dataFiles['autorizacionPublicacion']->move(WRITEPATH . 'uploads/tramites/autorizacionesPublicacion/', $nameFileAP);
        
        }

        
        return true;

    }

    public function saveURLpublicacion($idTramite,$URL){
        
        try{

           $responseUpdate= $this->update($idTramite,['urlpublicacion_tramite' => $URL]);
           return $responseUpdate;

        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }

    }

}
