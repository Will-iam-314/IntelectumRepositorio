<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\SolicitantesModel;

use App\Libraries\MailService;


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
   
    public function createUser($data, $rol){
        
        try{


            $token = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);      
            $idNewUser = $this->insert([
                'email_usuario' => $data['email'],
                'password_usuario' => $data['password'],
                'rol_usuario'=>$rol,
                'estado_usuario' => 2,
                'activation_token_usuario' => $token
                
            ]);

            switch ($rol){

                case 'solicitante':
                    $solicitante = new SolicitantesModel();
                    $boolNewSolicitante = $solicitante->createSolicitante($data,$idNewUser);
                    if($boolNewSolicitante){
                        $mail = new MailService();
                        $nombres =$data['nombres'].' '. $data['apellidos'];
                        $boolmail = $mail->sendMail_ConfirmacionUsuario($data['email'],$token,$nombres);
                        
                        if($boolmail){
                            return true;
                        }else{
                            return false;
                        }
                        
                    }else{
                        return false;
                    }
                break;

            }

           

        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }
  
    }

    public function updateUser($id){

    }

    public function getUser($id){

    }

    public function getUsers(){

    }

    

}
