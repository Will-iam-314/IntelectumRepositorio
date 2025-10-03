<?php

namespace App\Models;

use CodeIgniter\Model;

class TesisModel extends Model
{
    protected $table            = 'tesis';
    protected $primaryKey       = 'id_tesi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        'resumen_tesi',
        'fechaSustentacion_tesi',
        'palabrasclave_tesi',
        'campoinvestigacion_tesi',
        'campoaplicacion_tesi',
        'documento_tesi',
        'linea_tesi',
        'gradoAcademicoOptar_tesi',
        'descripcionGradoAcademico_tesi',
        'docente_asesor_tesi',
        'docente_jurado1_tesi',
        'docente_jurado2_tesi',
        'docente_jurado3_tesi'

    ];

    
    protected $useTimestamps = true;
    protected $createdField  = 'date_created_tesi';
    protected $updatedField  = 'date_updated_tesi';
  
    public function newTesis($data,$URLfile){
      
        $asesordata = $data['Asesor'].'|'.$data['AsesorDNI'].'|'.$data['AsesorORCID'];

        try{

            $idnewTesis = $this->insert([

                'resumen_tesi'=> $data['resumenTesis'],
                'fechaSustentacion_tesi'=> $data['FechaSustentacion'],
                'palabrasclave_tesi'=> $data['keywordsTesis'],
                'campoinvestigacion_tesi'=> $data['CampoInvestigacion'],
                'campoaplicacion_tesi'=> $data['CampoAplicacion'],
                'documento_tesi'=> $URLfile,
                'linea_tesi'=> $data['lineaInvestigacion'],
                'gradoAcademicoOptar_tesi' => $data['gradoTipo'],
                'descripcionGradoAcademico_tesi' => $data['gradoDescripcion'],
                'docente_asesor_tesi'=> $asesordata,
                'docente_jurado1_tesi'=> $data['PresidenteJurado'],
                'docente_jurado2_tesi'=> $data['PrimerMiembroJurado'],
                'docente_jurado3_tesi'=> $data['SegundoMiembroJurado']

            ]);
            

            return $idnewTesis;

        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }
        
    }

}
