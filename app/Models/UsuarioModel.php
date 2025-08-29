<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id_usuario';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        'email_usuario',
        'password_usuario',
        'rol_usuario',
        'estado_usuario',
        'activation_token_usuario',
        'reset_token_usuario',
        'reset_token_expired_usuario' 

    ];

  
    protected $useTimestamps = true;
    protected $createdField  = 'date_created_usuario';
    protected $updatedField  = 'date_updated_usuario';
   
    public function validateUser($email,$pass){
        
    }

}
