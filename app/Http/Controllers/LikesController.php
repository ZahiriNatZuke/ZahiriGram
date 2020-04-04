<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Post $post
     * @return mixed
     */
    public function store(Post $post)
    {
        return auth()->user()->pleasing()->toggle($post);
    }
}
