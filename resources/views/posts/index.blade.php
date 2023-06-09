@extends('layouts.app')

@section('content')

    <div class ="row mt-5" >
        <div class="col-md12">
            <h2>My Post </h2>
            <a href="{{ route('posts.create') }}" class ="btn btn-success my-3 ">Create new post</a> 
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif

    <table class = "table table-bordered">
        <tr>
            <th>No.</th>
            <th>Title</th>
            <th>Description</th>
            <th width="280px">Action</th>
        </tr>

        @foreach($posts as $key => $post)      
                <tr>
                <td>{{ $key + ++$i }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ Str::limit($post->description, 100) }}</td>
                <td>
                        <form id ="delete-post-form" action="{{route('posts.destroy',$post->id) }}" method="post">
                        <a href ="{{ route('posts.show',$post->id) }}" class="btn btn-info"> Show </a>
                        <a href ="{{ route('posts.edit',$post->id) }}" class="btn btn-warning"> Edit </a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"> Delete </button>
                    </form>
                </td>
            </tr>
        @endforeach

    </table>

    {!! $posts->links() !!}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('#delete-post-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault(); // Prevent the default form submission

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#157347',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If the user confirms, submit the form
                            Swal.fire(
                                'Deleted!',
                                'Your post has been deleted.',
                                'success'
                            );
                            event.target.submit();
                        }
                    });
                });
            });
        });
    </script>

@endsection