<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Autenticação bem-sucedida
            return redirect()->intended('/dashboardUser'); // Redireciona para a página de destino após o login
        }

        // Autenticação falhou
        return redirect()->back()->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
