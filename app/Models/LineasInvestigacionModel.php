<?php

namespace App\Models;

use CodeIgniter\Model;

class LineasInvestigacionModel extends Model
{
    protected $table            = 'lineasinvestigacion';
    protected $primaryKey       = 'id_linea';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        'nombre_linea',
        'id_escuela_linea'

    ];


    public function getLineas(){

        $lineas = $this->findAll();
        $data = ['lineas' => $lineas];
        return $data;
    }
    

}
