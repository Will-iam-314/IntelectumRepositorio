<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\TesisModel;

class MaterialModel extends Model
{
    protected $table            = 'material';
    protected $primaryKey       = 'id_materia';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        'autores_materia',
        'titulo_materia',
        'id_tesi_materia',
        'tipo_materia'

    ];



    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'date_created_materia';
    protected $updatedField  = 'date_updated_materia';


    public function newMaterial($data,$fileT){

        $autores = implode('/',$data['autores']);
        try{

            $tesiModel = new TesisModel();
            $idTesis = $tesiModel->newTesis($data,$fileT);

            if($idTesis){
                $idNewMaterial = $this->insert([
                'autores_materia'=>$autores,
                'titulo_materia'=>$data['tituloTesis'],
                'id_tesi_materia'=> $idTesis,
                'tipo_materia' => 1
                ]);

                return $idNewMaterial; 

            }else{
                return false;

            }

        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }

    }
}
