<?php

namespace App\Models;

use CodeIgniter\Model;

class DpiAdminModel extends Model
{
    protected $table            = 'dpiadministradores';
    protected $primaryKey       = 'id_dpiadmin';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        'nombres_dpiadmin',
        'apellidos_dpiadmin',
        'dni_dpiadmin',
        'id_usuario_dpiadmin'


    ];


    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'date_created_dpiadmin';
    protected $updatedField  = 'date_updated_dpiadmin';

     public function getDpiAdmin($idUser){

        try{
            $dataDpiAdmin = $this->where('id_usuario_dpiadmin',$idUser)->first();
            
            return $dataDpiAdmin;
        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }   
    }

   
}
