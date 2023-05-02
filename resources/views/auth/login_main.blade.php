@php
    if (Auth::check()) {
        echo '<script>window.location = "'.url('/dashboard').'";</script>';
    }
@endphp

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('auth_title')</title>

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <style>
        .shadow-non{ box-shadow: none!important }
    </style>
  </head>

  <body>
    <div>
        @if(Session::has('success'))
            <div class="row">
                <div class="col-4 "></div>
                <div class="col-4 mt-4">
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                       <span> {{ Session::get('success') }} </span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                <div class="col-4 "></div>
            </div>
            @elseif (Session::has('error'))
            <div class="row">
                <div class="col-4 "></div>
                <div class="col-4 mt-4">
                    <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                        <span> {{ Session::get('error') }} </span>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
                    </div>
                </div>
                <div class="col-4 "></div>
            </div>
        @endif
      <div class="container w-50 d-flex justify-content-center align-items-center mt-5" >

        @yield('auth_content')
      </div>
    </div>

  </body>
</html>
