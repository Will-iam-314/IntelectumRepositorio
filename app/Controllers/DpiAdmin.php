<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DpiAdmin extends BaseController
{
    public function index()
    {
        return view('dpi/home');
    }
}
