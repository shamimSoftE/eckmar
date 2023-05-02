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

            <div class="container mt-5">

                <div class="p-5 shadow-lg">
                    <h2 class="fw-bold mb-5">Mnemonic!</h2>

                    <span>
                        This is mnemonic key.
                        {{-- It consists out of 24 words. --}}
                        Please write them down. This is only time they will be shown to you, and without them
                        you cannot recover your account in case you lose password.
                    </span>

                    <div class="mt-3 w-100" style="border-radius: 5px; background-color: #bbb4b445; padding: 15px;">
                        <p class="w-100" style="overflow: auto;" title="Double Click To Select All">{{ $code_m }}</p>
                    </div>

                    {{-- <div class="row">
                        <div class="col-lg-2 col-2"></div>
                        <div class="col-lg-8 col-8">
                            <span>
                                This is mnemonic key. It consists out of 24 words. Please write them down. This is only time they will be shown to you, and without them
                                you cannot recover your account in case you lose password.
                            </span>

                            <div class="mt-3" style=" border-radius: 5px; background-color: #bbb4b445; padding: 15px;">
                                <p>{{ $code_m }}</p>
                            </div>
                        </div>
                        <div class="col-lg-2 col-2"></div>
                    </div> --}}

                    <div class="text-center px-5">
                        <a href="{{ url('/market-place') }}" class="btn btn-success mt-3 py-2 fw-semibold" > Login </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
