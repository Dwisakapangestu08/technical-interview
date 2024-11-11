<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        $var['title'] = 'Login';
        return view('auth.login', $var);
    }

    public function register()
    {
        $var['title'] = 'Register';
        return view('auth.register', $var);
    }

    public function forgot_password()
    {
        $var['title'] = 'Forgot Password';
        return view('auth.forgot', $var);
    }

    public function dashboard()
    {
        $var['title'] = 'Dashboard';
        return view('dashboard', $var);
    }
}
