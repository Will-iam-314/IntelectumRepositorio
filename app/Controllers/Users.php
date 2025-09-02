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
            'password' => 'required|max_length[50]|min_length[8]',
            'repassword' => 'matches[password]'
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
            return view('Auth/verificacionCorreo');
        } else{
           //retornar a una vista que muestre el error
        }

    }
}
