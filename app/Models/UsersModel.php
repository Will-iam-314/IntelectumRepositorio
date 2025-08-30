<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
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
   
    public function createUser($data){
        $token = bin2hex(random_bytes(20));

        print_r($data);
        $data;

        $this->insert([
            'email_usuario' => 0,
            'password_usuario' => 0,
            'rol_usuario'=>0,
            
        ]);
        
    }

    public function updateUser($id){

    }

    public function getUser($id){

    }

    public function getUsers(){

    }

    

}
