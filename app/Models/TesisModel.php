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
        'id_linea_tesi',
        'id_docente_asesor_tesi',
        'id_docente_jurado1_tesi',
        'id_docente_jurado2_tesi',
        'id_docente_jurado3_tesi'

    ];

    
    protected $useTimestamps = true;
    protected $createdField  = 'date_created_tesi';
    protected $updatedField  = 'date_updated_tesi';
  
    public function newTesis($data,$URLfile){

        try{

            $idnewTesis = $this->insert([

                'resumen_tesi'=> $data['resumenTesis'],
                'fechaSustentacion_tesi'=> $data['FechaSustentacion'],
                'palabrasclave_tesi'=> $data['keywordsTesis'],
                'campoinvestigacion_tesi'=> $data['CampoInvestigacion'],
                'campoaplicacion_tesi'=> $data['CampoAplicacion'],
                'documento_tesi'=> $URLfile,
                'id_linea_tesi'=> $data['lineaInvestigacion'],
                'id_docente_asesor_tesi'=> $data['Asesor'],
                'id_docente_jurado1_tesi'=> $data['PresidenteJurado'],
                'id_docente_jurado2_tesi'=> $data['PrimerMiembroJurado'],
                'id_docente_jurado3_tesi'=> $data['SegundoMiembroJurado']

            ]);
            

            return $idnewTesis;

        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }
        
    }

}
