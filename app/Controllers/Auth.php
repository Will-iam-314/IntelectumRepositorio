<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;


use App\Models\EscuelasModel;
use App\Models\UsersModel;
use App\Models\SolicitantesModel;

class Auth extends BaseController{

    public function getViewlogin(){
        return view('Auth/Login'); 
    }

    public function getViewregistro(){
        
        $escuelas = new EscuelasModel();
        $datos = $escuelas->getEscuelas();        
        return view('Auth/Register',$datos);
    }

    public function getViewVerificacion(){
        return view('Auth/verificacionCorreo');
    }

    public function authentication(){
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|'
        ];

        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('errors',$this->validator->listErrors());
        }

        $userModel = new UsersModel();
        $post = $this->request->getPost(['email','password']);

        $user = $userModel->validateUser($post['email'], $post['password']);

        if($user !==null){
           
            switch($user['rol_usuario']){
                case 'solicitante':
                    $solicitanteModel = new  SolicitantesModel();
                    $solicitanteData = $solicitanteModel->getSolicitante($user['id_usuario']);
                    $dataRol=[
                        'idDatarol' => $solicitanteData['id_solicitante'],
                        'nombres' => $solicitanteData['nombres_solicitante'],
                        'apellidos' =>$solicitanteData['apellidos_solicitante']
                    ];
                    $this->setSession($user,$dataRol);
                    return redirect()->to(base_url('solicitante/home')); 
                default:
                    return redirect()->to(base_url('/'));

            }
        }

        return redirect()->back()->withInput()->with('errors','el usuario y/o contraseña son incorrectos.');

    } 

    public function setSession($userData,$dataRol){
        

        $data = [
            'logged_in' => true,
            'id' => $userData['id_usuario'],
            'rol' => $userData['rol_usuario'],
            'datarol_id'=>$dataRol['idDatarol'],
            'nombres'=>$dataRol['nombres'],
            'apellidos'=>$dataRol['apellidos'],
            'correo' => $userData['email_usuario']
            
        ];

        $this->session->set($data);
    }

    public function logout(){
        if($this->session->get('logged_in')){
            $this->session->destroy();

        }
        return redirect()->to(base_url());
    }

    

    

}


?>