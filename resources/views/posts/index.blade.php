@extends('layouts.app')

@section('content')
    <div class="container px-5 pt-2">
        <div class="row">
            <div class="col-8 offset-2">
                <hr>
            </div>
        </div>
        @if(count($posts) > 0)
            @foreach($posts as $post)
                <div class="row">
                    <div class="col-8 offset-2">
                        <a href="{{route('post.show',['post'=>$post->id])}}">
                            <img src="/storage/{{$post->image}}" alt="{{explode('/',$post->image)[2]}}" class="w-100 rounded"
                                 style="max-height: 440px">
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8 offset-2">
                        <div class="pt-2 d-flex justify-content-between align-items-baseline">
                            <div class="d-flex">
                                <div class="pt-2 pl-1">
                                    <a href="{{route('profile.show', ['user'=>$post->user->id])}}">
                                        <span class="text-dark font-weight-bold pr-2">{{$post->user->username}}</span>
                                    </a>
                                    {{$post->caption}}
                                </div>
                            </div>
                            <div class="d-flex pl-1">
                                <div id="post-count-{{ $post->id }}" class="pr-4 d-flex">
                                    <b>{{ $post->comments->count() }}</b>
                                    <i class="fa fa-1x fa-comment-o pl-1 pt-1"></i>
                                </div>
                                <div id="like-count-{{ $post->id }}" class="pr-4 d-flex">
                                    <b>{{ $post->lovers->count() }}</b>
                                    <like-link id="like-{{ $post->id }}" post-id="{{ $post->id }}"
                                               likes="{{ $post->lovers->contains(Auth::user()->id) }}"></like-link>
                                </div>
                                <button class="btn btn-outline-dark btn-sm" data-toggle="modal"
                                        data-target="#modal-post-{{ $post->id }}" style="font-size: 10px">Comment
                                </button>
                            </div>
                        </div>
                        <ul id="list-post-{{ $post->id }}" class="p-2 m-0 list-unstyled mt-2 card customized-scroll"
                            style="max-height: 150px;overflow-x: paged-x ; overflow-y: scroll;@if($post->comments->count() == 0) display: none; @endif">
                            @for($i = 0; $i < $post->comments->count() && $i < 5; $i++)
                                <li id="post-{{ $post->id }}-comment-{{ $i }}" class="d-flex">
                                    <p class="m-0">
                                        <span class="font-weight-normal">{{ $post->comments[$i]->body }}</span>
                                        <span class="text-muted font-weight-bold px-1"> //</span>
                                        <span class="text-muted">{{ explode(' ', $post->comments[$i]->created_at)[0] }}
                                            </span>
                                        <span class="font-weight-normal pl-1" style="font-size: 13px">
                                            <a class="text-dark"
                                               href="{{route('profile.show', ['user'=>$post->comments[$i]->user->id])}}">
                                        <b style="font-size: 12px">@</b>{{$post->comments[$i]->user->username}}</a>
                                        </span>
                                    </p>
                                </li>
                            @endfor
                        </ul>
                    </div>
                </div>
                <div class="row pb-1">
                    <div class="col-8 offset-2">
                        <hr>
                    </div>
                </div>
                <comment-modal id="modal-post-{{ $post->id }}" user="{{ Auth::user()->username }}"
                               user-id="{{ Auth::user()->id }}" post-id="{{ $post->id }}"></comment-modal>
            @endforeach
        @else
            <div class="col-8 offset-2">
                <h1>Select Some Users to Follow Please</h1>
                <div class="row">
                    @foreach($welcome as $user)
                        <div class="col-6 py-2">
                            <div class="col-12 row p-0 m-0">
                                <div class="col-4 p-0">
                                    <img src="{{ $user->profile->profileImage() }}" class="w-100 rounded-circle"
                                         alt="">
                                </div>
                                <div class="col-8">
                                    <div class="pt-2 d-flex align-items-start">
                                        <a href="{{ route('profile.show', ['user'=>$user->id]) }}">
                                            <h5 class="text-dark font-weight-bold">{{ $user->name }}</h5>
                                        </a>
                                    </div>
                                    <span><b>@</b></span>
                                    <span class="text-dark">{{ $user->username }}</span>
                                    <follow-link user-id="{{$user->id}}" style="font-size: 12px"
                                                 follows="{{auth()->user()->following->contains($user->id)}}"></follow-link>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('post.index') }}" id="next-link" class="text-muted">
                <i class="fa fa-arrow-right fa-3x"></i>
            </a>
        @endif
    </div>
@endsection

<style>
    div.container {
        outline: none;
    }

    a {
        text-decoration: none !important;
    }

    #next-link {
        position: absolute;
        right: 60px;
        bottom: 40px;
    }

    #next-link:hover {
        color: #343a40 !important;
    }
</style>
