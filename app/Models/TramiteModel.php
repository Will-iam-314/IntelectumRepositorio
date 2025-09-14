<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\MaterialModel;

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
        'id_materia_tramite'

    ];

    
    // Dates
    protected $useTimestamps = false;
    protected $createdField  = 'date_created_tramite';
    protected $updatedField  = 'date_updated_tramite';
    
    
    public function newTramite($data,$URLfileT,$URLfileDJ,$URLfileAP){

        try{


            $materialModel = new MaterialModel();
            $idMaterialModel = $materialModel->newMaterial($data,$URLfileT);

          

            $idnewTramite = $this->insert([
                'codigo_tramite'=> $this->generaCodigo(),
                'declaracionJurada_tramite' => $URLfileDJ,
                'autorizacionPublicacion_tramite' => $URLfileAP,
                'id_estadotramite_tramite'=> 1,
                'id_solicitante_tramite' => $data['idsolicitante'],
                'id_materia_tramite' => $idMaterialModel
            ]);

            return $idnewTramite;

            

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

}
