@extends('auth.login_main')

@section('auth_title', 'Login Page')

@section('auth_content')


<div class="p-5 shadow-lg">
    <h1 class="text-center fw-bold mb-5">Welcome Back!</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label class="form-label mb-0">Username</label>
        <div class="input-group mb-3 mt-0">
            <span class="border border-1 border-secondary p-2"><i class="fa-solid fa-user-tie" style="color: gray;"></i></span>
            <input type="text" placeholder="Enter Username" name="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror border shadow-none border-1 border-success" />
        </div>
        @error('username')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label class="form-label mb-0">Password</label>
        <div class="input-group mb-3 mt-0">
            <span class="border border-1 border-secondary p-2"><i class="fa-solid fa-unlock-keyhole" style="color: gray;"></i></span>
            <input type="password" name="password" placeholder="Enter Password" class="form-control @error('password') is-invalid @enderror shadow-none border border-1 border-success"/>
        </div>
        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="text-center">
        <a href="{{ url('/password-forgot') }}" class="text-decoration-none">Forgot password?</a>
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
        <button type="submit" class="btn btn-success mt-3 w-100 py-2 fw-semibold" >
            Login
        </button>

        <span>Need an account?<a href="{{ url('/register') }}" class="text-decoration-none py-2">Register</a></span >
        </div>
    </form>
  </div>


@endsection
