<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PostsController extends Controller
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

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');
        $users->push(auth()->user()->id);

        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->get();
        $welcome = User::query()
            ->where('id', 'NOT LIKE', Auth::user()->id)
            ->with('profile')->with('following')
            ->take(10)->get();

        return view('posts.index', compact('posts', 'welcome'));
    }

    /**
     * @return View
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'caption' => 'required',
            'image' => ['required', 'image']
        ]);

        $path = request('image')->store('uploads/user-' . auth()->user()->id, 'public');

        $data['image'] = $path;
        Auth::user()->posts()->create($data);

        return redirect('/profile/' . auth()->user()->id);
    }

    /**
     * @param Post $post
     * @return Factory|View
     */
    public function show(Post $post)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($post->user->id) : false;

        $likes = $post->lovers->contains(auth()->user()->id);

        return view('posts.show', compact('post', 'follows', 'likes'));
    }

    public function search($query)
    {
        $users = User::query()
            ->where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('username', 'LIKE', '%' . $query . '%')
            ->with('profile')
            ->with('following')
            ->latest()->get();
        $posts = Post::query()
            ->where('caption', 'LIKE', '%' . $query . '%')
            ->with('user')
            ->latest()->get();
        return response()->json(['posts' => $posts, 'users' => $users, 'me' => auth()->user()->id], 200);
    }

}
