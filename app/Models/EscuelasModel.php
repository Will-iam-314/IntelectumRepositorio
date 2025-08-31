<?php

namespace App\Models;

use CodeIgniter\Model;

class EscuelasModel extends Model
{
    protected $table            = 'escuelas';
    protected $primaryKey       = 'id_escuela';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        'nombre_escuela',
        'id_facultad_escuela'

    ];


    public function getEscuelas(){
        $escuelas = $this->findAll();
        $data = ['carreras' => $escuelas];
        return $data;
    }
    

}
