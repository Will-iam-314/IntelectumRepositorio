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
 

 
}
