<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialRevisionesModel extends Model
{
    protected $table            = 'materialrevisiones';
    protected $primaryKey       = 'id_materiarevision';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        'id_inspector_materiarevision',
        'id_administrador_materiarevision',
        'id_materia_materiarevision ',
        'observacion_materiarevision',
        'estado_materiarevision'

    ];

  

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'date_create_materiarevision';
    protected $updatedField  = 'date_updated_materiarevision';
 

 
    public function newRevision($data){
         try{

            $idnewRevision = $this->insert([

                'id_inspector_materiarevision' => $data['idInspector'],
                'id_administrador_materiarevision'=> $data['idAdmin'],
                'id_materia_materiarevision '=> $data['idMaterial'],
                'observacion_materiarevision'=> $data['observaciones'],
                'estado_materiarevision'=> $data['estadoRevision']

            ]);
           
                
            if($idnewRevision){
                return true;
            }else{
                return false;
            }
          
        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }
    }

    public function getRevisiones($idMaterial){
        try{

            $revisiones = $this->select('observacion_materiarevision')->where('id_materia_materiarevision',$idMaterial)->first();
            
            return $revisiones;
          
        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }
    }
}
