@extends('layouts.app')

@section('content')
    <div class="container px-5 pt-4">
        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="row">
                <div class="col-8 offset-2">
                    <div class="row d-flex align-items-center justify-content-between">
                        <h1>Add New Post</h1>
                        <button type="submit" class="btn btn-primary">Add New Post</button>
                    </div>

                    <div class="form-group row">
                        <label for="caption" class="col-md-4 col-form-label">{{ __('Post Caption') }}</label>

                        <input id="caption" type="text"
                               class="form-control @error('caption') is-invalid @enderror" name="caption"
                               value="{{ old('caption') }}" required autocomplete="caption" autofocus>

                        @error('caption')
                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center">
                        <img id="profile-img" class="img-thumbnail w-50" src="" alt=""
                             style="display: none; max-height: 250px">
                    </div>
                    <div class="input-group">
                        <div class="w-100">
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
        profile_img.style.display = 'initial';
    }
</script>
