<?php

namespace App\Models;

use CodeIgniter\Model;

class HistorialTramitesModel extends Model
{
    protected $table            = 'historialtramites';
    protected $primaryKey       = 'id_historiatramite ';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        'usuario_historiatramite',
        'estado_historiatramite',
        'id_usuario_historiatramite',
        'id_tramite_historiatramite'
    ];


    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'date_created_historiatramite';
    protected $updatedField  = 'date_updated_historiatramite';
 
    public function newHistorialTramite($idUser,$idTramite,$rolUser,$estadoTramite){
        try{


            $idHistorialTram = $this->insert([
                'usuario_historiatramite' => $rolUser,
                'estado_historiatramite' => $estadoTramite,
                'id_usuario_historiatramite'=> $idUser,
                'id_tramite_historiatramite' => $idTramite
            ]);

        }catch(Exception $e){
            log_message('error', $e->getMessage()); 
        }
    }

    public function validateInspectorAsignation($idTramite,$idUser){
        try{

            $datosHistrial = $this->where('id_tramite_historiatramite',$idTramite)->findAll();

            foreach($datosHistrial as $dato){
                if( isset($dato['id_usuario_historiatramite']) && $dato['id_usuario_historiatramite'] == $idUser){
                    return true;
                }
            }
           
            return false;
        }catch(Exception $e){
            log_message('error', $e->getMessage()); 
        }
    }

}
