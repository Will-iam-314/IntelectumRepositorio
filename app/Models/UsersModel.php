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
        'reset_token_usuario'
    

    ];

    protected $useTimestamps = true;
    protected $createdField  = 'date_created_usuario';
    protected $updatedField  = 'date_updated_usuario';
    
   
    public function createUser($data, $rol){
        
        try{


            $token = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);      
            $idNewUser = $this->insert([
                'email_usuario' => $data['email'],
                'password_usuario' => password_hash($data['password'], PASSWORD_DEFAULT),
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

    public function activationUser($token){
        try{
            $user = $this->where(['activation_token_usuario'=>$token, 'estado_usuario'=> 2])->first();
            if($user){
                $this->update($user['id_usuario'],
                
                    [
                        'estado_usuario'=>1,
                        'activation_token_usuario'=>''
                    ]
                
                );

                return true;
            }else{
                return false;
            }
           
        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }
    }

    public function sendTokenRecoverPass($email){

        try{
            $user = $this->where('email_usuario', $email)
            ->groupStart()
                ->where('estado_usuario', 1)
                ->orWhere('estado_usuario', 3)
            ->groupEnd()
            ->first();
             
            $token = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);     

            if($user){
                

                $this->update($user['id_usuario'],
                
                    [
                        'estado_usuario'=>3,
                        'reset_token_usuario'=>$token
                    ]
                
                );

                $mail = new MailService();
                $mail->sendMail_RecoverPassCode($email,$token);


                return true;
            }else{
                return false;
            }

           

        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }

    }

    public function validateRecoverPass($token){
        try{
            $user = $this->where(['reset_token_usuario'=>$token, 'estado_usuario'=> 3])->first();
            if($user){
                $this->update($user['id_usuario'],
                
                    [
                        'estado_usuario'=>1,
                        'reset_token_usuario'=>''
                    ]
                
                );

                return $user['id_usuario'];
            }else{
                return false;
            }
           
        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }
    }

    public function updatePassword($idUser,$data){
        try{
            $user = $this->where(['id_usuario'=>$idUser])->first();
            if($user){
                $this->update($user['id_usuario'],
                
                    [
                        'password_usuario'=>password_hash($data['nevo_password'], PASSWORD_DEFAULT)
                        
                    ]
                
                );
                $mail = new MailService();
                $mail->sendMail_RecoverPass($user['email_usuario']);
                return true;
            }else{
                return false;
            }
           
        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return false;
        }

    }

    public function validateUser($email,$password){
        $user = $this->where(['email_usuario' => $email, 'estado_usuario' => 1])->first();
        if($user && password_verify($password, $user['password_usuario'])){
            return $user;
        }

        return null;

    }

    public function updateUser($id){

    }

    public function getUser($id){

    }

    public function getUsers(){

    }

    

}
