@extends('auth.login_main')

@section('auth_title', 'Reset Password')

@section('auth_content')


<div class="p-5 shadow-lg">
    <h1 class="text-center fw-bold mb-5">Reset Password</h1>
    <form method="POST" action="{{ url('reset_password') }}">
        @csrf
        <div class="input-group mb-3 mt-0">
            <input type="text" placeholder="Enter Username" name="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror border shadow-none border-1" />
        </div>
        @error('username')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="input-group mb-3 mt-0">
            <textarea name="mnemonic" minlength="22" cols="15" rows="5" placeholder="Mnemonic" class="form-control @error('username') is-invalid @enderror border shadow-none border-1">{{ old('mnemonic') }}</textarea>
        </div>
        @error('mnemonic')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="input-group mb-3 mt-0">
            <input type="password" name="password" placeholder="New Password" class="form-control @error('password') is-invalid @enderror shadow-none border border-1"/>
        </div>
        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="input-group mb-3 mt-0">
            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control @error('password_confirmation') is-invalid @enderror shadow-none border border-1"/>
        </div>


        <div class="text-center px-5">
            <div class="bg-dark text-danger p-3 my-2" style=" text-decoration: line-through;letter-spacing: 9px; ">
                @if(Session::has('captcha'))
                    <i>{{ Session::get('captcha') }}</i>
                @endif
            </div>
            <input type="text" class="form-control shadow-none @error('captcha') is-invalid @enderror" name="captcha" placeholder="Enter Captcha" />
            @error('captcha')
                <div class="alert alert-danger mt-1">{{ $message }}</div>
            @enderror
            <button type="submit" class="btn btn-outline-success mt-3 w-100 py-2 fw-semibold" >
                Reset password
            </button>

            <span class="text-center">Already have an account?</span >
        </div>
    </form>
  </div>


@endsection
