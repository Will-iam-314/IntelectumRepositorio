<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Solicitante extends BaseController
{
    public function index()
    {
        return view('Solicitante/home');
    }
}

?>