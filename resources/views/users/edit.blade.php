@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('My Profile') }}</div>

                <div class="card-body">

                    <form id="update-profile-form" action="{{ route('users.update-profile')}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for ="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" value=" {{$user->name}}">
                        </div>

                        <div class="form-group">
                            <label for ="dateofbirth">Date of Birth</label>
                            <input type="date" class="form-control" name="dateofbirth" id="dathofbirth"value="{{$user-> dateofbirth}}">
                        </div>

                        <div class="form-group">
                            <label for ="about">About Me</label>
                            <textarea name="about" id="about" cols="5" rows="5" class ="form-control"> {{$user->about}}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success my-3" onclick="showConfirmation()"  >Update</button>
                        <a href="{{ route('home') }}" class="btn btn-danger my-3" role="button">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('update-profile-form').addEventListener('submit', function (event) {
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
