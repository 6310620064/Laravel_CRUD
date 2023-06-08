@extends('layouts.app')

@section('content')

    <div class="row mt-5">
        <div class="col-md-12">
        <h2>Add new post</h2>
        </div>   
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong>
            Some problems with your input <br><br>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="post">
        @csrf

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Title:</strong>
                    <input type="text" name="title" class= "form-control" placeholder="Enter Title">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Descriptpion:</strong>
                <textarea class="form-control" style="height: 150px" name="description" placeholder="Enter description"></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-success my-3"> Submit </button>
                <a href="{{ route('posts.index') }}" class ="btn btn-primary my-3"> Back </a>

            </div>
        </div>
    </form>

@endsection