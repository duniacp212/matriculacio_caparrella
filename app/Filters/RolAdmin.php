<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RolAdmin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!in_array(session()->get('rol'), ['super admin', 'administracio'])) {
            return redirect()->to('/alumnes')->with('error', 'No tens permisos per accedir a aquesta secció.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}