<?php


namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthRedirectRolFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Si ya está logueado → redirigir al home según rol
        if (session()->get('logged_in')) {
            $rol = session()->get('rol');

            switch ($rol) {
                case 'solicitante':
                    return redirect()->to(base_url('solicitante/home'));
                case 'administrador':
                    return redirect()->to(base_url('admin/home'));
                case 'dpi':
                    return redirect()->to(base_url('dpi/home'));
                case 'inspector':
                    return redirect()->to(base_url('inspector/home'));
                default:
                    return redirect()->to(base_url('/'));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}



?>