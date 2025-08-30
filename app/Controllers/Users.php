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
        $this->usersModel->createUser($post);
    }
}
