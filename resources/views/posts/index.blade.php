@extends('layouts.app')

@section('content')
    <div class="container px-5 pt-2">
        <div class="row">
            <div class="col-8 offset-2">
                <hr>
            </div>
        </div>
        @foreach($posts as $post)
            <div class="row">
                <div class="col-8 offset-2">
                    <a href="{{route('post.show',['post'=>$post->id])}}">
                        <img src="/storage/{{$post->image}}" alt="{{explode('/',$post->image)[2]}}" class="w-100"
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
                            <div id="like-count-{{ $post->id }}" class="pr-4 d-flex"><b>{{ $post->lovers->count() }}</b>
                                <like-link id="like-{{ $post->id }}" post-id="{{ $post->id }}"
                                           likes="{{ $post->lovers->contains(Auth::user()->id) }}"></like-link>
                            </div>
                            <button class="btn btn-outline-dark btn-sm" data-toggle="modal"
                                    data-target="#modal-post-{{ $post->id }}" style="font-size: 10px">Comment
                            </button>
                        </div>
                    </div>
                    <ul id="list-post-{{ $post->id }}" class="p-2 m-0 list-unstyled mt-2 card"
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
    </div>
@endsection

<style>
    div.container {
        outline: none;
    }

    a {
        text-decoration: none !important;
    }
</style>
