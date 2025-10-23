<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\IndexController;
use App\Http\Controllers\PostController;

Route::get('/', [IndexController::class, 'index'])->name('home'); //->middleware(['r']);
Route::get('/posts', [PostController::class, 'index'])->name('post.index');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('post.show');

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/posts/comment/{id}', [PostController::class, 'comment'])->name('comment');
});
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login_process', [AuthController::class, 'login'])->name('login_process');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register_process', [AuthController::class, 'register'])->name('register_process');

    Route::get('/forgot', [AuthController::class, 'showForgotForm'])->name('forgot');
    Route::post('/forgot_process', [AuthController::class, 'forgot'])->name('forgot_process');
});
Route::get('/contacts', [IndexController::class, 'showContactForm'])->name('contacts');
Route::post('/contact_form_process', [IndexController::class, 'contactForm'])->name('contact_form_process');



