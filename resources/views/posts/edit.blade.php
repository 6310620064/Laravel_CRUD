@extends('layouts.app')

@section('content')

    <div class="row mt-5">
        <div class="col-md-12">
            <h2>Edit Post</h2>
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

    <form id="update-post-form" action="{{ route('posts.update', $post->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Title:</strong>
                    <input type="text" name="title" value="{{ $post->title }}" class= "form-control" placeholder="Enter Title">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Descriptpion:</strong>
                <textarea class="form-control" style="height: 150px" name="description" placeholder="Enter description">{{ $post->description }}</textarea>
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-success my-3" onclick="showConfirmation()" > Update </button>
                <a href="{{ route('posts.index') }}" class="btn btn-primary my-3">Back</a>
            </div>
        </div>
    </form>
    
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('update-post-form').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission
            
            Swal.fire({
                title: 'Do you want to save the changes?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Save',
                denyButtonText: `Don't save`,
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user confirms, submit the form
                    Swal.fire('Edit Success!', '', 'success')
                    this.submit();
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info');
                }
            });
        });
    });
</script>

@endsection