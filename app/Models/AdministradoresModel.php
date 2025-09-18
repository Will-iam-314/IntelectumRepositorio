<?php

namespace App\Models;

use CodeIgniter\Model;

class AdministradoresModel extends Model
{
    protected $table            = 'administradores';
    protected $primaryKey       = 'id_administrador';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        'nombres_administrador',
        'apellidos_administrador',
        'dni_administrador',
        'id_usuario_administrador'

    ];

    
    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'date_created_administrador';
    protected $updatedField  = 'date_updated_administrador';

    public function getAdministrador($idUser){

        try{
            $dataAdmin = $this->where('id_usuario_administrador',$idUser)->first();
            
            return $dataAdmin;
        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }   
    }

}
