<header class="mb-2">

    @php
        $user = Auth::user();
        $wallet = App\Models\Wallet::where('user_id', $user->id)->first();
        $wishlist = App\Models\Wishlist::where('open_by', $user->id)->get();
        $btc_rate = App\Models\CurrancyType::where('currancy_type', 'btc')->first()->rate;
        $xmr_rate = App\Models\CurrancyType::where('currancy_type', 'xmr')->first()->rate;
        $dogo_rate = App\Models\CurrancyType::where('currancy_type', 'dogo')->first()->rate;
        // $1 = .....
        $btc = $wallet->balance*$btc_rate;
        $xmr = $wallet->balance*$xmr_rate;
        $dogo = $wallet->balance*$dogo_rate;
    @endphp


    <!-- Main Navbar -->
    <nav class="navbar navbar-expand-md bg-success">
      <div class="container-fluid mx-4">
        <a class="navbar-brand" href="{{ url('/dashboard') }}">
          <img src="{{ asset('assets/uploads/logo/logo.png') }}" alt="Logo" width="100" height="30" class="d-inline-block text-white align-text-top"/>
        </a>
        <button class="navbar-toggler text-white" style="background-color: white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon text-white"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link mx-2 menu-hover text-white py-0" aria-current="page" href="{{ url('/market-place') }}">Home</a>
            </li>

            <li class="nav-item">
              <a class="nav-link mx-2 menu-hover text-white py-0" aria-current="page" href="{{ url('/products') }}">Products</a>
            </li>
            <li class="nav-item">
                @switch($user->type)
                    @case(1)
                        <a class="nav-link mx-2 menu-hover text-white py-0" aria-current="page" href="{{ url('/seller-order') }}">Order</a >
                    @break
                    @default
                        <a class="nav-link mx-2 menu-hover text-white py-0" aria-current="page" href="{{ url('/order-view') }}">Order</a >
                @endswitch
            </li>
            <li class="nav-item">
                @switch($user->type)
                @case(2)
                    <a class="nav-link mx-2 menu-hover text-white py-0" aria-current="page" href="{{ url('/support-panel') }}">Support</a>
                    @break
                @default
                    <a class="nav-link menu-hover text-white py-0" aria-current="page" href="{{ url('/support') }}" >Support</a>
            @endswitch

            </li>
            <li class="nav-item border-0">
                @switch($user->type)
                    @case(1)
                        <a class="nav-link menu-hover text-white py-0" aria-current="page" href="{{ url('/seller-dashboard') }}" >Vendor</a>
                        @break
                    @default
                        <a class="nav-link menu-hover text-white py-0" aria-current="page" href="{{ url('/vendor-request') }}" >Vendor</a>
                @endswitch

            </li>
            {{-- <li class="nav-item">
              <a class="nav-link mx-2 menu-hover text-white py-0" href="#"
                >Wishlist</a
              >
            </li>
            <li class="nav-item border-0">
              <a class="nav-link mx-2 menu-hover text-white py-0" href="#"
                >T&C</a
              >
            </li> --}}
          </ul>
        </div>
        <div class="m-0 p-0 text-white short-list d-lg-block d-none">
          <div class="d-flex last-menu m-0 p-0">
            <span class="my-0 me-2 p-0">{{ $user->name }}</span>

            @switch($user->type)
                @case(3)
                    <a href="{{ url('/admin-panel') }}" class="m-0 p-0 text-white signout">Admin Panel</a>
                    @break
                @case(2)
                    <a href="{{ url('/support-panel') }}" class="m-0 p-0 text-white signout">Support Panel</a>
                    @break
                @case(1)
                    <a href="{{ url('/seller-dashboard') }}" class="m-0 p-0 text-white signout">Dashboard</a>
                    @break

                @default

            @endswitch


          </div>
          <div class="d-flex last-menu m-0 p-0">
            <span class="my-0 me-2 p-0">Last seen</span>
            <p class="m-0 p-0">@if(!empty($user->last_login)) {{ date('d/m/Y', strtotime( $user->last_login)) }} @else {{ date('d/m/Y') }}@endif</p>
          </div>
          <div class="d-flex last-menu m-0 p-0">
            <p class="my-0 me-2 p-0">Member Since</p>
            <p class="m-0 p-0">{{ date('d/m/Y', strtotime( $user->created_at)) }}</p>
          </div>
          {{-- <div class="d-flex last-menu m-0 p-0">
            <p class="my-0 me-2 p-0">Current Role</p>
            <p class="m-0 p-0">

                 @if( == 0)  @elseif($user->) {{ __('Admin') }}@endif
                </p>
          </div> --}}

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <div class="d-flex last-menu m-0 p-0">

                <a href="{{ route('logout') }}" class="m-0 p-0 text-white signout"  onclick="event.preventDefault();
                this.closest('form').submit();">Sign out</a>

                {{-- <a href="#" class="m-0 p-0 link-light text-decoration-none"> &nbsp; &nbsp; &nbsp; &nbsp;<i class="fa-solid fa-gear"></i></a> --}}
                <a href="{{ url('profile/user',sha1(Auth::user()->id)) }}" class="m-0 p-0 link-light text-decoration-none" title="Profile"> &nbsp; &nbsp; &nbsp; &nbsp;<i class="fa-solid fa-user"></i></a>
                <a href="{{ url('/notifications') }}" class="m-0 p-0 link-light text-decoration-none"> &nbsp; &nbsp; &nbsp; <i class="fa-solid fa-bell"></i></a>
                <a href="{{ url('/wishlist') }}" title="view wishlist" class="m-0 p-0 link-light text-decoration-none"> &nbsp; &nbsp; &nbsp;<i class="fa-solid fa-heart"></i><sup class="badge bg-danger">@if(isset($wishlist)) {{ count($wishlist) }} @endif</sup></a>
            </div>

          </form>
        </div>
      </div>
    </nav>

    <!-- Sub Nav -->
    <div class="shadow">
      <div class="container py-2 mx-auto text-center">
        <div class="d-flex mx-2 md-mx-auto mx-auto text-success">

          <div class="mx-auto me-4">
          </div>
          <div class="mx-auto me-1">
            <h6 class="m-0 p-0">
             <a href="{{ url('/wallet') }}" class="text-decoration-none text-success"> BTC</a> <span class="fw-bold f-4">$@if(!empty($wallet->balance)){{ number_format($wallet->balance,2) }} @else {{ 00 }} @endif</span>
            </h6>
            <p class="m-0 p-0">@if(!empty($btc)) {{ number_format($btc,7) }}  @else 0.0000000 @endif</p>
            <p class="m-0 p-0">$@if(!empty($wallet->balance)){{ number_format($wallet->balance,2) }} @else {{ 00 }} @endif</p>
          </div>
          {{-- <div class="mx-auto text-success">
            <h6 class="m-0 p-0"><a href="{{ url('/wallet') }}" class="text-decoration-none text-success">BCH </a><span class="fw-bold">$300</span></h6>
            <p class="m-0 p-0">0.0000000</p>
            <p class="m-0 p-0">$0.00</p>
          </div>
          <div class="mx-auto text-success">
            <h6 class="m-0 p-0"><a href="{{ url('/wallet') }}" class="text-decoration-none text-success">LTC</a> <span class="fw-bold">$200</span></h6>
            <p class="m-0 p-0">0.0000000</p>
            <p class="m-0 p-0">$0.00</p>
          </div> --}}
          <div class="mx-auto me-1 text-success">
            <h6 class="m-0 p-0"><a href="{{ url('/wallet') }}" class="text-decoration-none text-success">XMR</a> <span class="fw-bold">$@if(!empty($wallet->balance)){{ number_format($wallet->balance,2) }} @else {{ 00 }} @endif</span></h6>
            <p class="m-0 p-0">@if(!empty($xmr)) {{ number_format($xmr,7) }}  @else 0.0000000 @endif</p>
            <p class="m-0 p-0">$@if(!empty($wallet->balance)){{ number_format($wallet->balance,2) }} @else {{ 00 }} @endif</p>
          </div>

          <div class="mx-auto me-1 text-success">
            <h6 class="m-0 p-0">
              <a href="{{ url('/wallet') }}" class="text-decoration-none text-success">DOGO</a> <span class="fw-bolder">$@if(!empty($wallet->balance)){{ number_format($wallet->balance,2) }} @else {{ 00 }} @endif</span>
            </h6>
            <p class="m-0 p-0">@if(!empty($dogo)) {{ number_format($dogo,2) }}  @else 0.0000000 @endif</p>
            <p class="m-0 p-0">$@if(!empty($wallet->balance)){{ number_format($wallet->balance,2) }} @else {{ 00 }} @endif</p>
          </div>
          <div class="mx-auto me-6">
        </div>
          {{-- <div class="mx-auto text-success">
            <h6 class="m-0 p-0"><a href="{{ url('/wallet') }}" class="text-decoration-none text-success">DASH</a> <span class="fw-bold">$200</span></h6>
            <p class="m-0 p-0">0.0000000</p>
            <p class="m-0 p-0">$0.00</p>
          </div>
          <div class="mx-auto text-success">
            <h6 class="m-0 p-0"><a href="{{ url('/wallet') }}" class="text-decoration-none text-success">ZCASH</a> <span class="fw-bold">$150</span></h6>
            <p class="m-0 p-0">0.0000000</p>
            <p class="m-0 p-0">$0.00</p>
          </div> --}}
        </div>
      </div>
    </div>
  </header>
