<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UsersModel;

class Users extends BaseController
{
    protected $usersModel;

    public function __construct()
    {
        
        $this->usersModel = new UsersModel();
    }

    public function nuevoUsuario(){

        $rules= [
            'nombres'=>'required|alpha_space',
            'apellidos'=> 'required|alpha_space',
            'dni'=>'required|integer|max_length[8]|min_length[8]|is_unique[solicitantes.dni_solicitante]',
            'carrera'=>'required',
            'email' =>'required|valid_email|max_length[100]|is_unique[usuarios.email_usuario]',
            'password' => [
                'rules' => 'required|max_length[50]|min_length[8]',
                'errors' => [
                    'required' => 'La Contraseña es Obligatoria',
                    'max_length' => 'La Contraseña es demasiado larga',
                    'min_length' => 'La Contraseña debe de tener al menos 8 caracteres'
                ]
            ],
            'repassword' => [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'La Contraseñas no Coinciden'
                ]
            ]
        ];
        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('errors',$this->validator->listErrors());
        }

        $post = $this->request->getPost();
        $rol = 'solicitante';   

       
        /*
        si el rol de la sesion actual es administrador , seleccione el tipo de rol que desee sino por defecto solicitante.
        si no hay sesion, no puede asignar rol?
        */

       $boolUser = $this->usersModel->createUser($post,$rol);
       

        if($boolUser){            
            return redirect()->to(base_url('verificar'));
        } else{
           //retornar a una vista que muestre el error
        }

    }

    public function verificarUsuario(){

        $rules = [
            'codigo' => [
                'rules' => 'required|numeric|exact_length[5]',
                'errors'=> [
                    'required' => 'El codigo es Obligatorio',
                    'numeric'  => 'El codigo ingresado es incorrecto',
                    'exact_length' => 'El codigo ingresado es muy extenso o muy corto'
                ]
            ]
        ];

        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('errors',$this->validator->listErrors());
        }

        $post = $this->request->getPost();
        $token = $post['codigo'];
        $boolVerification = $this->usersModel->activationUser($token);

        if($boolVerification){
            return view('Auth/verificacionExitosaCorreo');
        }else{
            return redirect()->back()->withInput()->with('errors','Codigo Incorrecto');
        }
    }

    


}
