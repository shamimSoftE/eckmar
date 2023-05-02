@extends('FrontEnd.main')

@section('title', 'Dashboard')

@push('style')

<style>
    .circle {
        height: 55px;
        width: 55px;
        border: 1px solid #bbb;
        border-radius: 50%;
        display: inline-block;
    }
    .c_active{ color: #ffffff!important; background-color: #198754; }
    .cfs-12{
        font-size: 12px;
    }
    /* .page-link{
        background-color: #198754 !important;
        border: 1px solid #198754 !important;
        color: white !important;
    } */
</style>

@endpush

@section('content')

    <div class="row justify-content-between mt-5 mb-3 mx-0 px-5">
        <div class="col-lg-12 col-md-12">
            <h5 class="fw-bold"><span >{{ $user->name }} </span> &nbsp; Dashboard</h5>
            <div class="pb-3 bg-white">
                <span class="cfs-12 text-muted" style="letter-spacing: 1px; word-spacing: 10px; display: flex; justify-content: space-around;">
                    Member Since {{ date('d M Y', strtotime( $user->created_at)) }} |
                    Vendor Since {{ date('d M Y', strtotime( $user->vendor_since)) }} |
                    {{-- Disputes is last 12 months (Won 0/Losted 0)  (0) | --}}
                    Completed Orders: @if(isset($order_complete)) {{ count($order_complete) }} @endif |
                    Rate Orders: @if(isset($order_review)) {{ count($order_review) }} @endif
                </span>
            </div>
        </div>

        <div class="col-lg-2 col-md-2">
            <div class="shadow rounded pl-1">
                <div class="list-group rounded-0 border-0">
                    <a href="{{ url('seller-dashboard') }}" class="list-group-item fw-bold @if(request()->segment(1) == 'seller-dashboard') c_active @endif" style="padding: 12px"> Dashboard </a>
                    <a href="{{ url('product_create') }}" class="list-group-item fw-bold @if(request()->segment(1) == 'product_create') c_active @endif" style="padding: 12px"> Add Product </a>
                    <a href="{{ url('product_list') }}" class="list-group-item fw-bold @if(request()->segment(1) == 'product_list') c_active @endif" class="list-group-item fw-bold " style="padding: 12px"> My Products </a>
                    <a href="{{ url('seller-order') }}" class="list-group-item fw-bold @if(request()->segment(1) == 'seller-order') c_active @endif" style="padding: 12px"> My Orders </a>
                </div>
            </div>
        </div>

        <div class="col-lg-10 col-md-10">

            <div class="user-div">
                <div class="row shadow p-3">



                    <div class="col-lg-5 col-md-5 text-start">
                        <h3>{{ $user->name }}</h3>
                        {{-- <span class="border p-1">lavel 1</span> <span class="text-muted">(0 XP)</span> --}}
                        <h6 class="mt-3">Feedback Ratings</h6>
                        <strong class="float-start ">Quality : </strong>
                        @if(!empty($product_reviews->avg('quality_review')))
                            @switch(number_format($product_reviews->avg('quality_review')))
                                @case(5)
                                    {!! '<span style="font-size: 19px;color:#f58020;"> ☆ ☆ ☆ ☆ ☆ </span>'; !!}
                                    @break
                                @case(4)
                                    {!! '<span style="font-size: 19px;color:#f58020;"> ☆ ☆ ☆ ☆ </span> <span style="font-size: 19px;"> ☆ </span>'; !!}
                                    @break
                                @case(3)
                                    {!! '<span style="font-size: 19px;color:#f58020;"> ☆ ☆ ☆ </span> <span style="font-size: 19px;"> ☆ ☆ </span>'; !!}
                                    @break
                                @case(2)
                                    {!! '<span style="font-size: 19px;color:#f58020;"> ☆ ☆  </span> <span style="font-size: 19px;"> ☆ ☆ ☆</span>'; !!}
                                    @break
                                @case(1)
                                    {!! '<span style="font-size: 19px;color:#f58020;"> ☆   </span> <span style="font-size: 19px;"> ☆ ☆ ☆ ☆</span>'; !!}
                                    @break
                                @default
                                <span style="font-size: 19px;"> ☆ ☆ ☆ ☆ ☆ </span>
                            @endswitch
                        @else
                            <span style="font-size: 19px;"> ☆ ☆ ☆ ☆ ☆ </span>
                        @endif
                        <br>
                        <strong class="float-start ">Shipping : </strong>
                        @if(!empty($product_reviews->avg('shipping_review')))
                            @switch(number_format($product_reviews->avg('shipping_review')))
                                @case(5)
                                    {!! '<span style="font-size: 19px;color:#f58020;"> ☆ ☆ ☆ ☆ ☆ </span>'; !!}
                                    @break
                                @case(4)
                                    {!! '<span style="font-size: 19px;color:#f58020;"> ☆ ☆ ☆ ☆ </span> <span style="font-size: 19px;"> ☆ </span>'; !!}
                                    @break
                                @case(3)
                                    {!! '<span style="font-size: 19px;color:#f58020;"> ☆ ☆ ☆ </span> <span style="font-size: 19px;"> ☆ ☆ </span>'; !!}
                                    @break
                                @case(2)
                                    {!! '<span style="font-size: 19px;color:#f58020;"> ☆ ☆  </span> <span style="font-size: 19px;"> ☆ ☆ ☆</span>'; !!}
                                    @break
                                @case(1)
                                    {!! '<span style="font-size: 19px;color:#f58020;"> ☆   </span> <span style="font-size: 19px;"> ☆ ☆ ☆ ☆</span>'; !!}
                                    @break
                                @default
                                <span style="font-size: 19px;"> ☆ ☆ ☆ ☆ ☆ </span>
                            @endswitch
                            @else
                            <span style="font-size: 19px;"> ☆ ☆ ☆ ☆ ☆ </span>
                        @endif
                    </div>

                    <div class="col-lg-7 col-md-7 text-start">
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="row">
                                    <div class="col-auto"><span class="circle" style=" background: #198754;"></span></div>
                                    <div class="col-auto mt-2"><strong class="fs-3 text-center">@if(isset($order_feedback->review_positive)) {{ $order_feedback->review_positive }} @endif</strong></div>
                                </div>
                                <strong class="text-center">Positive</strong>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="row">
                                    <div class="col-auto"><span class="circle" style="background: #f58020;"></span></div>
                                    <div class="col-auto mt-2"><strong class="fs-3 text-center">@if(isset($order_feedback->review_neutral)) {{ $order_feedback->review_neutral }} @endif</strong></div>
                                </div>
                                <strong class="text-center">Neutral</strong>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="row">
                                    <div class="col-auto"><span class="circle" style=" background:#d71616ed;"></span></div>
                                    <div class="col-auto mt-2"><strong class="fs-3 text-center">@if(isset($order_feedback->review_negative)) {{ $order_feedback->review_negative }} @endif</strong></div>
                                </div>
                                <strong class="text-center">Negative</strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                              <button class="nav-link active" id="about_seller-tab" data-bs-toggle="tab" data-bs-target="#about_seller-tab-pane" type="button" role="tab" aria-controls="about_seller-tab-pane" aria-selected="true">About</button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Profile</button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link" id="feedback-tab" data-bs-toggle="tab" data-bs-target="#feedback-tab-pane" type="button" role="tab" aria-controls="feedback-tab-pane" aria-selected="false">Feedback</button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link" id="withdraw-tab" data-bs-toggle="tab" data-bs-target="#withdraw-tab-pane" type="button" role="tab" aria-controls="withdraw-tab-pane" aria-selected="false">Withdrawn</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade show active" id="about_seller-tab-pane" role="tabpanel" aria-labelledby="about_seller-tab" tabindex="0">
                                <div class="mt-3 w-100" style="border-radius: 5px; {{-- background-color: #bbb4b445; --}} padding: 15px;">
                                    {{ $user->about }}
                                </div>
                            </div>

                            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                <div class="mt-3 w-100" style="border-radius: 5px; padding: 15px;">
                                    <form action="{{ url('seller_update') }}" method="POST">
                                        @csrf
                                        <div class="card" style="width: 50rem;">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label text-start d-flex">Title</label>
                                                    <input type="text" class="form-control" id="title" name="title" value="{{ $user->title }}" placeholder="seller shop title">
                                                    <small class="text-muted">It'll show customer product details page</small>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="about" class="form-label  text-start d-flex">Example textarea</label>
                                                    <textarea class="form-control" id="about" name="about" rows="10">{{ $user->about }}</textarea>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-success" style="float: right">Update</button>
                                            </div>
                                        </div>
                                   </form>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="feedback-tab-pane" role="tabpanel" aria-labelledby="feedback-tab" tabindex="0">
                                <div class="mt-3 w-100" style="border-radius: 5px; padding: 15px;">
                                    <div class="text-start">

                                        <strong >Average Rating: </strong>
                                        @if(!empty($product_reviews->avg('quality_review')))

                                            @switch(number_format($product_reviews->avg('quality_review')))
                                                @case(5)
                                                    {!! '<span style="font-size: 19px;color:#f58020;"> ☆ ☆ ☆ ☆ ☆ </span>'; !!}
                                                    @break
                                                @case(4)
                                                    {!! '<span style="font-size: 19px;color:#f58020;"> ☆ ☆ ☆ ☆ </span> <span style="font-size: 19px;"> ☆ </span>'; !!}
                                                    @break
                                                @case(3)
                                                    {!! '<span style="font-size: 19px;color:#f58020;"> ☆ ☆ ☆ </span> <span style="font-size: 19px;"> ☆ ☆ </span>'; !!}
                                                    @break
                                                @case(2)
                                                    {!! '<span style="font-size: 19px;color:#f58020;"> ☆ ☆  </span> <span style="font-size: 19px;"> ☆ ☆ ☆</span>'; !!}
                                                    @break
                                                @case(1)
                                                    {!! '<span style="font-size: 19px;color:#f58020;"> ☆   </span> <span style="font-size: 19px;"> ☆ ☆ ☆ ☆</span>'; !!}
                                                    @break
                                                @default
                                                <span style="font-size: 19px;"> ☆ ☆ ☆ ☆ ☆ </span>
                                            @endswitch
                                        @else
                                            {{-- <strong>☆ ☆ ☆ ☆ ☆</strong> --}}
                                            <span style="font-size: 19px;"> ☆ ☆ ☆ ☆ ☆ </span>
                                        @endif

                                        @if(isset($product_reviews)) <sup class="badge bg-danger">{{ number_format($product_reviews->avg('quality_review'),1) }}</sup> <br> <strong>Total Rating: </strong> <span class="badge bg-danger"> {{ count($product_reviews) }} </span> @endif

                                        <br>
                                    </div>

                                    <ul style="max-height: 481px; overflow-y: scroll; padding: 5px;">
                                        @if(isset($product_reviews))

                                            @foreach ($product_reviews as $key => $review)
                                                <li style="margin:5px 0 9px 0; " class="text-start">
                                                   {{ ++$key }}. <span class="text-capitalize">  {{ $review->feedback_message }}</span>
                                                    @if(isset($review->quality_review))
                                                        <br>
                                                       <span class="text-muted" style=" font-size: 13px; "> Rating:</span>
                                                        @switch(number_format($review->quality_review))
                                                            @case(5)
                                                                {!! '<span style="font-size: 15px;color:#f58020;"> ☆ ☆ ☆ ☆ ☆ </span>'; !!}
                                                                @break
                                                            @case(4)
                                                                {!! '<span style="font-size: 15px;color:#f58020;"> ☆ ☆ ☆ ☆ </span> <span style="font-size: 15px;"> ☆ </span>'; !!}
                                                                @break
                                                            @case(3)
                                                                {!! '<span style="font-size: 15px;color:#f58020;"> ☆ ☆ ☆ </span> <span style="font-size: 15px;"> ☆ ☆ </span>'; !!}
                                                                @break
                                                            @case(2)
                                                                {!! '<span style="font-size: 15px;color:#f58020;"> ☆ ☆  </span> <span style="font-size: 15px;"> ☆ ☆ ☆</span>'; !!}
                                                                @break
                                                            @case(2)
                                                                {!! '<span style="font-size: 15px;color:#f58020;"> ☆   </span> <span style="font-size: 15px;"> ☆ ☆ ☆ ☆</span>'; !!}
                                                                @break
                                                            @default
                                                            <span style="font-size: 15px;"> ☆ ☆ ☆ ☆ ☆ </span>
                                                        @endswitch
                                                        @endif
                                                    <br>
                                                    <span class="text-muted" style=" font-size: 13px; "> Reviewer: </span> @if(isset($review->customer->name)) {{ $review->customer->name }} @endif
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="withdraw-tab-pane" role="tabpanel" aria-labelledby="withdraw-tab" tabindex="0">
                                <div class="mt-3 w-100" style="border-radius: 5px; padding: 15px;">
                                    <form action="{{ url('seller_balance_withdraw') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12">
                                                <div class="card" style="width: 15rem;">
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <div class="flex flex-items-center">Balance available for use </div>
                                                            <strong class="text-center display-5"> <b style="color: #198754;"> ${{ number_format($seller_balance->balance,2) }} </b></strong>
                                                            <input type="hidden" name="total_withdraw" value="{{ $seller_balance->balance }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-success">Withdraw balance</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12">
                                                <div class="card" style="width: 20rem;">
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <div class="flex flex-items-center mb-3">Balance you want to withdraw </div>
                                                            <strong style=" font-size: 21px; color: #198754; "> <b> $</b> <input type="text" name="request_withdraw" value="" placeholder="00" maxlength="{{ $seller_balance->balance }}" max="{{ $seller_balance->balance }}" min="1" style="width: 33%;text-align: center;border: 1px solid #1987546e;color: #198754;border-radius: 5px;"></strong>
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-success">Withdraw Now</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                   </form>


                                   {{-- withdraw table --}}
                                   <div class="my-5">
                                       <div class="table-responsive mt-5" style="max-height: 467px;">
                                        <table class="table">
                                            <thead class="" style="background: #198754; color: white;">
                                                <th scope="col">#</th>
                                                <th scope="col">Amount</th>
                                                {{-- <th scope="col">Type</th> --}}
                                                <th scope="col">Status</th>
                                                <th scope="col">Date</th>
                                            </thead>
                                            <tbody>
                                                @if(isset($withdraws))

                                                    @foreach ($withdraws as $key => $withdraw)
                                                        <tr>
                                                            <td>{{ ++$key }}</td>
                                                            <td>${{ $withdraw->amount }}</td>
                                                            <td>
                                                                @if($withdraw->status == 0)
                                                                    <span class="badge text-bg-warning">Pending</span>
                                                                    @else
                                                                    <span class="badge text-bg-primary">Completed</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ date('d/m/Y', strtotime($withdraw->created_at)) }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                          </table>
                                       </div>
                                   </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>


            <div class="user-div">
                <div class="mt-5 p-3 shadow rounded news text-start">
                    <h2 class="text-capitalize text-start mb-3 fw-bold text-success">News</h2>
                    <div>
                        @if(isset($newsVendor))
                            @foreach ($newsVendor as $new)
                                <p class="text-capitalize">
                                    {{-- <a href="http://" target="_blank" rel="noopener noreferrer"> --}}
                                        {{ date('d/m/Y',strtotime($new->created_at)) }} <br />
                                    <strong style="cursor: pointer;" >{{ $new->header }}</strong>
                                    {{-- </a> --}}
                                </p>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            {{-- <div class="mt-5 p-3 shadow rounded news text-start">
                <div class="container mt-3">
                    <ul class="nav nav-pills mb-3 d-inline-flex" id="pills-tab" role="tablist" style=" display: flex!important; justify-content: space-evenly; flex-wrap: nowrap;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-topVendor-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-topVendor" type="button" role="tab" aria-controls="pills-topVendor" aria-selected="true">Top Vendor</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-topProduct-tab" data-bs-toggle="pill" data-bs-target="#pills-topProduct"
                            type="button" role="tab" aria-controls="pills-topProduct" aria-selected="false">Top Product</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-delivered-tab" data-bs-toggle="pill" data-bs-target="#pills-delivered"
                            type="button" role="tab" aria-controls="pills-delivered" aria-selected="false">Top Category</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">

                        <div class="tab-pane fade show active" id="pills-topProduct" role="tabpanel" aria-labelledby="pills-topProduct-tab">
                            <div class="table-responsive">
                                <table class="table table-border table-hover mt-5" style="height: 100%;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Vendor</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a href="{{ url('/order-delivered') }}" class="text-muted">#5665</a></td>
                                            <td>Bear</td>
                                            <td>3</td>
                                            <td>Wave Store</td>
                                            <td><span class="badge bg-success">Delivered</span></td>
                                            <td>$75</td>
                                            <td>12-12-2022 05:30PM</td>
                                        </tr>

                                        <tr>
                                            <td><a href="{{ url('/order-process') }}" class="text-muted">#5662</a></td>
                                            <td>Ticket</td>
                                            <td>1</td>
                                            <td>Online Store</td>
                                            <td><span class="badge bg-primary">Processing</span></td>
                                            <td>$45</td>
                                            <td>12-12-2022 01:30PM</td>
                                        </tr>

                                        <tr>
                                            <td><a href="{{ url('order-dispute') }}" class="text-muted">#5665</a></td>
                                            <td>Bear</td>
                                            <td>3</td>
                                            <td>Wave Store</td>
                                            <td><span class="badge bg-warning">Dispute</span></td>
                                            <td>$75</td>
                                            <td>12-12-2022 05:30PM</td>
                                        </tr>

                                        <tr>
                                            <td><a href="{{ url('order-complete') }}" class="text-muted">#5662</a></td>
                                            <td>Ticket</td>
                                            <td>1</td>
                                            <td>Online Store</td>
                                            <td><span class="badge bg-secondary">Completed</span></td>
                                            <td>$45</td>
                                            <td>12-12-2022 01:30PM</td>
                                        </tr>
                                        <tr>
                                            <td><a href="{{ url('order-cancelled') }}" class="text-muted">#5662</a></td>
                                            <td>Gift Card</td>
                                            <td>5</td>
                                            <td>Online Store</td>
                                            <td><span class="badge bg-danger">Canceled</span></td>
                                            <td>$99</td>
                                            <td>01-12-2022 02:00PM</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="mt-3 p-3 shadow rounded news text-start">
                <span class="border-bottom">Edit Profile</span>
                <div class="border p-5"></div>
                <button type="submit" class="btn btn-success mt-2"> Submit</button>
            </div> --}}

            {{-- <div class="mt-3 p-3 shadow rounded news"> --}}
                {{-- <h3 class="fw-bold text-start">Incomming</h3>

                <div class="border m-4 text-center">
                    <span class="p-2">BTC</span>
                    <span class="p-2">XMR</span>
                    <span class="p-2">DOGE</span>
                </div> --}}
                {{-- <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th class="border-bottom">Jan</th>
                            <th class="border-bottom">Feb</th>
                            <th class="border-bottom">Mar</th>
                            <th class="border-bottom">Apr</th>
                            <th class="border-bottom">May</th>
                            <th class="border-bottom">Jun</th>
                            <th class="border-bottom">Jul</th>
                            <th class="border-bottom">Aug</th>
                            <th class="border-bottom">Sep</th>
                            <th class="border-bottom">Oct</th>
                            <th class="border-bottom">Nov</th>
                            <th class="border-bottom">Dec</th>
                        </tr>
                        <tr>
                            <td colspan="4">Sale <br> Pending <br>Sold <br>On-Hold <br>Cancelled </td>
                            <td colspan="4">31 <br>0 <br> 1 </td>
                            <td colspan="4">$350 <br>$00 <br> $15 </td>
                        </tr>
                        <tr>
                            <td colspan="10">Total <br>Share <br>Paid </td>
                            <td colspan="2">$800 <br>$200 <br>$540 </td>
                        </tr>
                    </table>
                    <div class="text-center pb-3"> <span class="border p-2"> This Month Over All Paid : $0.00</span></div>
                </div> --}}
                {{-- <div class="m-4 text-start" style="word-spacing: 50px">
                    <span class="border-bottom">Jan</span>
                    <span class="border-bottom"></span>
                    <span class="border-bottom"></span>
                    <span class="border-bottom"></span>
                    <span class="border-bottom"></span>
                    <span class="border-bottom"></span>
                    <span class="border-bottom">July</span>
                    <span class="border-bottom">Aug</span>
                    <span class="border-bottom">Sep</span>
                    <span class="border-bottom">Oct</span>
                    <span class="border-bottom">Nov</span>
                    <span class="border-bottom">Dec</span>
                </div> --}}
            {{-- </div> --}}


        </div>


    </div>
@endsection
