@extends('layouts.app')

@section('content')

    <div class="row mt-5">
        <div class="col-md-12">
            <h2> Show Post</h2>
        </div>
    </div>

    <div class="row">
        <div class="card p-3">
            <div class="card-title">
                <strong>Title:</strong>
                {{ $post->title }}
            </div>
            <div class="card-text">
                <strong>Description:</strong>
                {{ $post->description }}
            </div>
        </div>
    </div>
    <a href="{{ route('posts.index') }}" class="btn btn-primary my-3">Back</a>



@endsection
