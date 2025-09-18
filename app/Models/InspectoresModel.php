<?php

namespace App\Models;

use CodeIgniter\Model;

class InspectoresModel extends Model
{
    protected $table            = 'inspectores';
    protected $primaryKey       = 'id_inspector';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        'nombres_inspector',
        'apellidos_inspector',
        'dni_inspector',
        'id_usuario_inspector'
    ];

  

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'date_created_inspector';
    protected $updatedField  = 'date_updated_inspector';
   
     public function getInspector($idUser){

        try{
            $dataInspect = $this->where('id_usuario_inspector',$idUser)->first();
            
            return $dataInspect;
        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }   
    }

}
