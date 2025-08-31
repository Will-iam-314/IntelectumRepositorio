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

    public function index()
    {
        return view('Login/registro');
    }

    public function nuevoUsuario(){
        $post = $this->request->getPost();
        $rol = 'solicitante';  

       
        /*
        si el rol de la sesion actual es administrador , seleccione el tipo de rol que desee sino por defecto solicitante.
        si no hay sesion, no puede asignar rol?
        */

       $boolUser = $this->usersModel->createUser($post,$rol);
       

        if($boolUser){
            
            return view('Auth/Login',['mensaje'=> 'Usuario Registrado Correctamente']);
        } else{
           
        }

    }
}
