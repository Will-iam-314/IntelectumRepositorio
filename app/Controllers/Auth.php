<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;


use App\Models\EscuelasModel;

class Auth extends BaseController{

    public function getViewlogin(){
        return view('Auth/Login'); 
    }

    public function getViewregistro(){
        
        $escuelas = new EscuelasModel();
        $datos = $escuelas->getEscuelas();

        
        return view('Auth/Register',$datos);
    }

    

    

}


?>