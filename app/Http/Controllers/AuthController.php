<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }
    public function Logout() {
        auth('web')->logout();
        return redirect(route('home'));
    }
    public function showRegisterForm() {
        return view('auth.register');
    }
    public function register(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
           'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
        if ($user) {
            auth('web')->login($user);
        }
        return redirect(route('home'));
    }
    public function login(Request $request) {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

       if (auth('web')->attempt($data)) {
           return redirect(route('home'));
       }
        return redirect(route('login'))->withErrors(['email' => 'Пользователь не найден']);
    }
}
