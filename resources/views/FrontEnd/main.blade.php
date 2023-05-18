<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <style>
        .nav-link, .nav-link:hover {
            color: #198754;
        }
         .nav-link:focus,{
            color: #ffffff;
         }
         .nav-pills {
            --bs-nav-pills-border-radius: 0.375rem;
            --bs-nav-pills-link-active-color: #fff;
            --bs-nav-pills-link-active-bg: #198754;
         }
         /* Scrollbar styles */
            ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
            }

            /* ::-webkit-scrollbar-track {
            border: 1px solid #198754;
            border-radius: 3px;
            } */

            ::-webkit-scrollbar-thumb {
            background: #198754;
            border-radius: 3px;
            }

            ::-webkit-scrollbar-thumb:hover {
            background: #065932;
            }
            .c_active{ color: #ffffff!important; background-color: #119b5a; }

      </style>
    @stack('style')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  </head>

  <body>
    <div class="container-fluid text-center p-0 m-0">
      <!-- Header Start -->
        @include('FrontEnd.include.header')
      <!-- Header End -->

      <!-- Main Start -->
      <main style="min-height: 350px;">

        @if(Session::has('success'))
            <div class="row">
                <div class="col-4 "></div>
                <div class="col-4 mt-4">
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    {{-- <span> {{ Session::get('success') }} </span> --}}
                     {{ Session::get('success') }}
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
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                <div class="col-4 "></div>
            </div>
        @endif


        {{-- @if (session('success'))
            <script>
                $(document).ready(function() {
                    toastr['success']('{{ session("success") }}', 'Success', {
                        closeButton: true,
                        tapToDismiss: false,
                        hideDuration: 500,
                        showMethod: 'slideDown',
                        hideMethod: 'slideUp',
                        timeOut: 3000,
                        progressBar: true
                    });
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                $(document).ready(function() {

                    toastr['error']('{{ session("error") }}', 'Failed!', {
                        closeButton: true,
                        tapToDismiss: false,
                        hideDuration: 500,
                        showMethod: 'slideDown',
                        hideMethod: 'slideUp',
                        timeOut: 3000,
                        progressBar: true
                        });
                });
            </script>
        @endif --}}

        @yield('content')

      </main>
      <!-- Main End -->

      <!-- Footer Start -->
      <footer class="text-center mt-5 text-lg-start text-dark" style="background-color: #eceff1">

        <!-- Copyright -->
        <div class="text-center p-3 bg-dark text-white">
          © 2020 Copyright: <a class="text-white" style="text-decoration: none" href="#">Digital Age</a>
        </div>
        <!-- Copyright -->
      </footer>
      <!-- Footer End -->
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    @stack('script')
  </body>
</html>
