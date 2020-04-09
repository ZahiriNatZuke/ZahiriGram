@extends('layouts.app')

@section('content')
    <div class="container px-5 pt-5">
        <div class="row">
            <div class="col-8">
                <img src="/storage/{{$post->image}}" alt="{{explode('/',$post->image)[2]}}" class="w-100 rounded"
                     style="max-height: 450px">
            </div>
            <div class="col-4">
                <div class="col-12 row">
                    <div class="col-3 p-0">
                        <img src="{{$post->user->profile->profileImage()}}" class="w-100 rounded-circle"
                             alt="{{explode('/',$post->user->profile->profileImage())[4]}}">
                    </div>
                    <div class="col-9">
                        <div class="pt-2 d-flex align-items-center">
                            <a href="{{route('profile.show', ['user'=>$post->user->id])}}">
                                <h4 class="text-dark font-weight-bold">{{$post->user->username}}</h4>
                            </a>
                            @if($post->user->id != Auth::user()->id)
                                <h5 class="font-weight-light pl-2">●</h5>
                                <follow-link user-id="{{$post->user->id}}" follows="{{$follows}}"></follow-link>
                            @endif
                        </div>
                        <div class="d-flex">
                            <div id="post-count-{{ $post->id }}" class="pr-4 d-flex">
                                <b>{{ $post->comments->count() }}</b>
                                <i class="fa fa-1x fa-comment-o pt-1 pl-1"></i>
                            </div>
                            <div id="like-count-{{ $post->id }}" class="pr-4 d-flex">
                                <b>{{ $post->lovers->count() }}</b>
                                <like-link id="like-{{ $post->id }}" post-id="{{ $post->id }}"
                                           likes="{{ $likes }}"></like-link>
                            </div>
                            <button class="btn btn-outline-dark btn-sm" data-toggle="modal"
                                    data-target="#modal-post-{{$post->id}}" style="font-size: 10px">Comment
                            </button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex">
                    <p class="m-0">
                        <a href="{{route('profile.show', ['user'=>$post->user->id])}}">
                            <span class="text-dark font-weight-bold pr-2">{{$post->user->username}}</span>
                        </a>
                        {{$post->caption}}
                    </p>
                </div>
                <ul id="list-post-{{ $post->id }}" class="pl-2 py-2 m-0 list-unstyled mt-2 card"
                    style="max-height: 250px; overflow-x: paged-x; overflow-y: scroll;@if($post->comments->count() == 0) display: none @endif">
                    @foreach($post->comments as $comment)
                        <li class="d-flex">
                            <p class="m-0">
                                <span class="font-weight-normal">{{ $comment->body }}</span>
                                <span class="text-muted font-weight-bold px-1"> //</span>
                                <span class="text-muted">
                                    {{ explode(' ', $comment->created_at)[0] }}
                                </span>
                                <span class="font-weight-normal pl-1" style="font-size: 13px">
                                <a class="text-dark" href="{{route('profile.show', ['user'=>$comment->user->id])}}">
                                    <b style="font-size: 12px">@</b>{{$comment->user->username}}</a>
                            </span>
                            </p>
                        </li>
                    @endforeach
                </ul>
                <comment-modal id="modal-post-{{ $post->id }}" user="{{ Auth::user()->username }}"
                               user-id="{{ Auth::user()->id }}" post-id="{{ $post->id }}"></comment-modal>
            </div>
        </div>
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
