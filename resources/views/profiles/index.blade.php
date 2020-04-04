@extends('layouts.app')

@section('content')
    <div class="container px-5">
        <div class="row">
            <div class="col-3 py-5 px-0">
                <img class="rounded-circle h-100 w-100" src="{{$user->profile->profileImage()}}" alt=""
                     style="max-height: 269px">
            </div>
            <div class="col-9 pt-5 pl-5">
                <div class="d-flex justify-content-between align-items-baseline">
                    <h1>{{$user->name}}</h1>
                    @auth
                        @if(Auth::user()->id == $user->id)
                            <a class="btn btn-success" href="{{route('post.create')}}">New Post</a>
                        @else
                            <follow-button user-id="{{$user->id}}" follows="{{$follows}}"></follow-button>
                        @endif
                    @endauth
                </div>
                <div class="d-flex align-items-center">
                    <p class="pt-2 font-weight-bold">@</p>
                    <p class="pt-2" style="font-size: 14px">{{ $user->username }}</p>
                    @can('update', $user->profile)
                        <a class="btn btn-sm btn-primary mb-2 ml-3"
                           href="{{route('profile.edit', ['user' => $user->id])}}">
                            Edit Profile</a>
                    @endcan
                </div>
                <div class="d-flex">
                    <div class="pr-4"><b>{{ $postsCount}}</b> posts</div>
                    <div class="pr-4"><b>{{ $followingCount }}</b> followers</div>
                    <div class="pr-4"><b>{{ $followersCount }}</b> following</div>
                    <div class="pr-4"><b>{{ $commentsCount }}</b> <i class="fa fa-1x fa-comment-o pl-1"></i></div>
                    <div class="pr-4"><b>{{ $likesCount }}</b> <i class="fa fa-1x fa-heart-o pl-1"></i></div>
                </div>
                <div class="pt-2 font-weight-bold">{{ $user->profile->title }}</div>
                <div>{{ $user->profile->description }}
                </div>
                <div><a href="{{$user->profile->url}}" style="color: #1b1e21">
                        {{ explode('//',$user->profile->url)[1] }}</a></div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <hr>
            </div>
        </div>
        <div class="row pt-3">
            @foreach($user->posts as $post)
                <div class="col-4 pb-4">
                    <a href="{{route('post.show',['post'=>$post->id])}}">
                        <img class="w-100" src="/storage/{{ $post->image }}" alt=""
                             style="height: 200px">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection

