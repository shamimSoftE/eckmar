@extends('FrontEnd.main')

@section('title', 'User Details')

@push('style')
<style>
    .c_active{ color: #ffffff; background-color: #198754; }
    .c_text{font-size: 12px!important; text-decoration: none!important; }
    .not-allow{ cursor:not-allowed; }
</style>
@endpush

@section('content')


    @php
        $wallet = App\Models\Wallet::where('user_id', $user->id)->first();
        $btc_rate = App\Models\CurrancyType::where('currancy_type', 'btc')->first()->rate;
        $xmr_rate = App\Models\CurrancyType::where('currancy_type', 'xmr')->first()->rate;
        $dogo_rate = App\Models\CurrancyType::where('currancy_type', 'dogo')->first()->rate;
        // $1 = .....
        $btc = $wallet->balance*$btc_rate;
        $xmr = $wallet->balance*$xmr_rate;
        $dogo = $wallet->balance*$dogo_rate;
    @endphp

    <div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5">
        <!-- left side -->
        <div class="col-xl-3 col-xxl-3 col-lg-3 col-md-2 text-start">
            <div class="shadow rounded">
                <div class="text-center py-2 rounded-top @if(request()->segment(1) == 'admin-panel') c_active @endif">
                    <a href="{{ url('/admin-panel') }}" class="text-decoration-none text-dark ">Market Statistics</a>
                </div>
                @include('FrontEnd.AdminPanel.include.sidebar')
            </div>
        </div>

        <!-- right side top part -->
        <div class="col-xl-8 col-xxl-8 col-lg-8 col-md-10 text-start">
            <div class="p-3 user-div shadow rounded">
                <div class="mb-4 inner-content">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">

                            <h3 class="pb-3 border-bottom text-start">User details for buyer</h3>

                            <div class="card">
                                <div class="card-header">Basic Infomation</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-3">
                                            <strong>Username:</strong>
                                            <br> <br>
                                            <span class="p-2 bg-light text-muted border">{{ $user->username }}</span>
                                        </div>

                                        <div class="col-3">
                                            <strong>Last Login:</strong>
                                            <br><br>
                                            <span class="p-2 bg-light text-muted border">{{ $user->last_login->diffForHumans() }}</span>
                                        </div>

                                        <div class="col-6">
                                            <strong>ID:</strong>
                                            <br><br>
                                            <span class="p-2 bg-light text-muted border">{{ App\Models\Magician::ed($user->id) }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 mt-3">
                            <form action="{{ route('user_permission') }}" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-header">User Group</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="user_type_vendor" @if($user->type == 1) checked @endif value="1" id="vendor">
                                                    <label class="form-check-label text-muted" for="vendor">Vendor</label>
                                                    <br> <small style="font-size: 12px">Give or take away user's ability to add new products </small>
                                                </div>
                                            </div>


                                            <div class="col-6">
                                                <label class="form-check-label" >Panel permission</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="user_type_dispute" @if($user->type == 2 || $user->support_panel == 1) checked @endif value="2"  id="dispute">
                                                    <label class="form-check-label text-muted" for="dispute">Support Panel</label>
                                                </div>
                                                {{-- <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="ticket">
                                                    <label class="form-check-label" for="ticket">Ticket</label>
                                                </div> --}}
                                                <small class="text-wrap" style="font-size: 12px; width: 6rem">Limited access to Admin Panel. Mainly resolves disputes </small>
                                            </div>
                                        </div>

                                        <input type="hidden" name="user_id" value="{{ $user->id }}">

                                    </div>
                                    <div class="card-footer">
                                        <center><button type="submit" class="btn btn-sm btn-success">Save Changes </button></center>
                                    </div>
                                </div>
                            </form>
                        </div>



                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 mt-3">
                            <form action="{{ route('user_wallet_modify') }}" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-header">User Balance</div>
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-xl-12 mb-3">
                                                <div style=" display: flex; justify-content: space-evenly; ">
                                                    <span> DOLLAR($) :
                                                        <input type="text" name="balance_dollar" style=" border-radius: 5px; border-color: #1881504f; width: 59%; padding: 3px; "
                                                         value="@if(!empty($wallet->balance)) {{ number_format($wallet->balance,7) }}  @else 0.0000000 @endif">
                                                    </span>
                                                </div>
                                            </div>

                                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                                            <div class="col-xl-4 col-lg-4 col-md-4">
                                                <div class="mb-3 row">
                                                    <label for="btc" class="col-sm-3 col-form-label">BTC</label>
                                                    <div class="col-sm-8">
                                                      <input type="text" class="form-control not-allow" id="btc" name="balance_btc" value="@if(!empty($btc)) {{ number_format($btc,7) }}  @else 0.0000000 @endif" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4">
                                                <div class="mb-3 row">
                                                    <label for="xmr" class="col-sm-3 col-form-label">XMR</label>
                                                    <div class="col-sm-9">
                                                      <input type="text" class="form-control not-allow" id="xmr" name="balance_xmr" value="@if(!empty($xmr)) {{ number_format($xmr,7) }}  @else 0.0000000 @endif" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4">
                                                <div class="mb-3 row">
                                                    <label for="dogo" class="col-sm-4 col-form-label">DOGO</label>
                                                    <div class="col-sm-8">
                                                      <input type="text" class="form-control not-allow" id="dogo" name="balance_dogo" value="@if(!empty($dogo)) {{ number_format($dogo,7) }}  @else 0.0000000 @endif" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <center><button type="submit" class="btn btn-sm btn-success">Save Changes </button></center>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 mt-3">
                            <div class="card">
                                <div class="card-header">Bans</div>
                                <div class="card-body">

                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Start</th>
                                            <th scope="col">End</th>

                                          </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($bans as $ban)
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>{{ date('Y/m/d', strtotime($ban->created_at)) }}</td>
                                                    <td>{{ date('Y/m/d', strtotime($ban->end_date)) }}</td>
                                                </tr>
                                            @empty
                                            <tr>

                                                <td colspan="3">
                                                    <div class="alert alert-success text-center" role="alert">
                                                        List of bans is empty
                                                      </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                      </table>

                                </div>


                                @php
                                    $userBanUntill = Carbon\Carbon::parse($user->banned_until);
                                    $today = Carbon\Carbon::now();
                                    $hoursDiff = $today->diffInDays($userBanUntill);
                                @endphp

                                @if($hoursDiff <= 1)
                                    <div class="card-footer">
                                        <form class="g-3" method="POST" action="{{ route('user.banned') }}">
                                            @csrf
                                            <div class="mb-3 row">
                                                <label for="user_ban" class="col-sm-6 col-form-label">Ban user for number of days from now</label>
                                                <div class="col-sm-4">
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <input type="number" class="form-control" id="user_ban" placeholder="Days" name="ban_for" >
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="submit" class="btn btn-outline-danger mb-3">Ban</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endif


                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection

@push('script')

@endpush
