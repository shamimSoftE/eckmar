@extends('FrontEnd.main')

@section('title', 'Update Your Information')

@section('content')
<div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5 mb-5">

    <div class="col-lg-1 col-md-1"></div>
    <div class="col-lg-10 col-md-10 text-start">
        <div class="p-3 user-div shadow rounded">
            <div class="mb-4 text-capitalize inner-content">
                <h5 class="mb-1 border-bottom p-2">Change Password</h5>

                <form action="{{ url('change-password') }}" method="POST">
                    @csrf
                    <div class="mb-3 row mt-3">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Old Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password">
                            @error('current_password')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <label for="inputPassword" class="col-sm-2 col-form-label mt-2">New Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control mt-2 @error('password') is-invalid @enderror"  name="password">
                            @error('password')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <center>
                            <button type="submit" class="btn btn-outline-success btn-sm mt-3">Change Password</button>
                        </center>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-1 col-md-1"></div>
</div>

@endsection
