<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }

    public function registerAction() {
        // Logic to register a new user
        // Redirect to login page with success message
        // return redirect()->route('login')->with('success', 'Registration successful!');
    }

    public function loginAction(Request $request) {
        // Logic to authenticate the user
        // Redirect to dashboard page with success message
        // return redirect()->route('dashboard')->with('success', 'Login successful!');
    }
}
