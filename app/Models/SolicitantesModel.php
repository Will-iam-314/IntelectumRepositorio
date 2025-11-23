<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\UsersModel;

class SolicitantesModel extends Model
{
    protected $table            = 'solicitantes';
    protected $primaryKey       = 'id_solicitante';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        'nombres_solicitante',
        'apellidos_solicitante',
        'dni_solicitante',
        'id_escuela_solicitante',
        'id_usuario_solicitante'

    ];

    
    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'date_created_solicitante';
    protected $updatedField  = 'date_updated_solicitante';


    public function createSolicitante($data,$idUser){
       try{
            $this->insert([
                'nombres_solicitante' => $data['nombres'],
                'apellidos_solicitante' => $data['apellidos'],
                'dni_solicitante' => $data['dni'],
                'id_escuela_solicitante' => $data['carrera'],
                'id_usuario_solicitante' => $idUser
            ]);
            return true;            
       }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
       }
    
    }
    

    public function getSolicitante($idUser){

        try{
            $dataSolicitante = $this->where('id_usuario_solicitante',$idUser)->first();
            if($dataSolicitante){
                return $dataSolicitante;
            }else{
                return false;
            } 
        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }   
    }
    
    public function getSolicitantePorDNI($dni){
        try{
            $dataSolicitante = $this->where('dni_solicitante',$dni)->first();
            if($dataSolicitante){
                $userModel = new UsersModel();
                $userData = $userModel->getUser($dataSolicitante['id_usuario_solicitante']);
                $dataSolicitante['correo'] = $userData['email_usuario'];
                return $dataSolicitante;
            }else{
                return false;
            } 
        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        } 
    }
}