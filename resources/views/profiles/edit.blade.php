@extends('layouts.app')

@section('content')
    <div class="container px-5 pt-5">
        <form action="{{ route('profile.update', ['user'=>$user->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="row">
                <div class="col-8 offset-2">
                    <div class="row">
                        <h1>Update Profile</h1>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group row">
                                <label for="title"
                                       class="col-md-4 font-weight-bold col-form-label">{{ __('Title') }}</label>

                                <input id="title" type="text"
                                       class="form-control @error('title') is-invalid @enderror" name="title"
                                       value="{{ old('title') ?? $user->profile->title }}" required autocomplete="title"
                                       autofocus>

                                @error('title')
                                <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="url"
                                       class="col-md-4 font-weight-bold col-form-label">{{ __('URL') }}</label>

                                <input id="url" type="text"
                                       class="form-control @error('url') is-invalid @enderror" name="url"
                                       value="{{ old('url') ?? $user->profile->url }}" required autocomplete="url"
                                       autofocus>

                                @error('url')
                                <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="description"
                                       class="col-md-4 font-weight-bold col-form-label">{{ __('Description') }}</label>

                                <textarea id="description" type="text" style="resize: none" rows="3" name="description"
                                          class="form-control @error('description') is-invalid @enderror" required
                                          autocomplete="description" autofocus>{{ old('description') ?? $user->profile->description }}
                        </textarea>

                                @error('description')
                                <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="pl-5">
                                <img id="profile-img" class="rounded-circle img-thumbnail"
                                     src="{{$user->profile->profileImage()}}"
                                     alt="" style="width: 80%;height: 70%">
                            </div>
                            <div class="input-group pl-3">
                                <div class="row w-100">
                                    <label for="image" class="col-md-4 col-form-label">{{ __('Post Image') }}</label>

                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image"
                                               onchange="onChange(event);">
                                        <label id="name-img" class="custom-file-label" for="image"
                                               style="overflow: hidden"></label>
                                    </div>

                                    @error('image')
                                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-3 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

<style>
    .custom-file-label::after {
        content: "Browse Image" !important;
        text-transform: uppercase;
    }
</style>

<script type="text/javascript">
    function onChange(event) {
        let file = event.target.files[0];
        let profile_img = document.getElementById('profile-img');
        document.getElementById('name-img').innerText = event.target.files[0].name;
        profile_img.src = window.URL.createObjectURL(file);
    }
</script>
