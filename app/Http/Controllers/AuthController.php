<?php

namespace App\Http\Controllers;
use App\Http\Requests\ForgotRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
    public function register(RegisterRequest $request) {
        $validated = $request->validated();
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password'])
        ]);
        if ($user) {
            auth('web')->login($user);
        }
        return redirect(route('home'));
    }
    public function login(LoginRequest $request) {
       $validated = $request->validated();
       if (auth('web')->attempt($validated)) {
           return redirect(route('home'));
       }
       return redirect(route('login'))->withErrors(['email' => 'Пользователь не найден']);
    }
    public function showForgotForm() {
        return view('auth.forgot');
    }
    public function forgot(ForgotRequest $request) {
        $validated = $request->validated();
        $user = User::where(['email' => $validated['email']])->first();
        $password = uniqid();
        $user->password = bcrypt($password);
        $user->save();
        Mail::to($user->email)->send(new ForgotPassword($password));
        return redirect(route('home'));
    }
}
