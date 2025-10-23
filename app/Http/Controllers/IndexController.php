<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactForm;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    public function index() {
        $post = Post::orderBy('created_at', 'desc')->limit(3)->get();

        return view('welcome', ['posts' => $post]);
    }
    public function showContactForm() {

        return view('contact_form');
    }
    public function contactForm(ContactFormRequest $request) {

        Mail::to('ordinarystory@yandex.ru')->send(new ContactForm($request->validated()));
        return redirect('/contacts');
    }
}
