@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('My Profile') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action ="{{ route('users.update-profile')}}" method ="POST">
                        @csrf
                        @method('PUT')
                        @if(Session::has('success'))

                            <div class="alert alert-success">

                                {{Session::get('success')}}

                            </div>

                        @endif
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

                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('home') }}" class="btn btn-danger" role="button">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
