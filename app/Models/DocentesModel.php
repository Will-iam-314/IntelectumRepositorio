<?php

namespace App\Models;

use CodeIgniter\Model;

class DocentesModel extends Model
{
    protected $table            = 'docentes';
    protected $primaryKey       = 'id_docente';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        'nombres_docente',
        'apellidos_docente',
        'dni_docente',
        'orcid_docente',
        'id_escuela_docente'


    ];

    
    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'date_created_docente';
    protected $updatedField  = 'date_updated_docente';


    public function getDocentes(){

        $docentes = $this->findAll();
        $data = ['docentes' => $docentes];
        return $data;
    }
}
