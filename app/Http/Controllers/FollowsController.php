<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class FollowsController extends Controller
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
     * @param User $user
     * @return mixed
     */
    public function store(User $user)
    {
        if ($user->id != auth()->user()->id)
            return auth()->user()->following()->toggle($user->profile);
    }
}
