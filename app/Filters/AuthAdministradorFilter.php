<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthAdministradorFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        service('auth');
        
        if (! session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        if (session()->get('rol') !== 'administrador') {
            return redirect()->to(base_url('login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}


?>