<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProfilesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @param User $user
     * @return Renderable
     */
    public function index(User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        $postsCount = Cache::remember('count.posts' . $user->id, now()->addSeconds(30), function () use ($user) {
            return $user->posts->count();
        });

        $followingCount = Cache::remember('count.following' . $user->id, now()->addSeconds(30), function () use ($user) {
            return $user->profile->followers->count();
        });

        $followersCount = Cache::remember('count.followers' . $user->id, now()->addSeconds(30), function () use ($user) {
            return $user->following->count();
        });

        $commentsCount = Cache::remember('count.comments' . $user->id, now()->addSeconds(30), function () use ($user) {
            return $user->comments()->count();
        });

        $likesCount = Cache::remember('count.likes' . $user->id, now()->addSeconds(30), function () use ($user) {
            return $user->pleasing->count();
        });

        return view('profiles.index', compact('user', 'follows', 'followersCount', 'followingCount', 'postsCount', 'commentsCount', 'likesCount'));
    }

    /**
     * @param User $user
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    /**
     * @param User $user
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user->profile);
        $data = $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'url' => ['required', 'url'],
            'image' => 'image',
        ]);

        if (request('image')) {
            $path = request('image')->store('uploads/profile-' . auth()->user()->id, 'public');
            $data['image'] = $path;
        }

        auth()->user()->profile()->update($data);

        return redirect("/profile/{$user->id}");
    }
}
