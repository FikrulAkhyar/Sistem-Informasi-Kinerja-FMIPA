<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;


class AuthGuard implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $isAuthRoute = strpos($request->uri->getPath(), 'auth/login') !== FALSE;
        $isLoggedIn = session('isLoggedIn');

        if ($isLoggedIn && $isAuthRoute) {
            return redirect()->to(base_url())->with('message', 'anda telah login');
        } else if (!$isLoggedIn && !$isAuthRoute) {
            return redirect()->to('auth/login')->with('message', 'anda belum login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
