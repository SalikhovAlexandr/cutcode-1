<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        $post = Post::orderBy('created_at', 'desc')->limit(3)->get();

        return view('welcome', ['posts' => $post]);
    }
}
