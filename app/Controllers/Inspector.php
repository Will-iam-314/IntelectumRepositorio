<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Inspector extends BaseController
{
    public function index()
    {
        return view('inspector/home');
    }
}
