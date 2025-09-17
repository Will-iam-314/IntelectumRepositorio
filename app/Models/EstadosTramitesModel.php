<?php

namespace App\Models;

use CodeIgniter\Model;

class EstadosTramitesModel extends Model
{
    protected $table            = 'estadotramites';
    protected $primaryKey       = 'id_estadotramite';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        'nombres_estadotramite'
    ];

   public function getAllEstadosTramites(){
     
        $estados = $this->findAll();
        return $estados;
   }
}
