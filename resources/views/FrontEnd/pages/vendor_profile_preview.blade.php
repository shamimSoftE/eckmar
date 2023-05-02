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
    .cfs-12{
        font-size: 12px;
    }
</style>

@endpush

@section('content')

    <div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5">

        <div class="user-div">
            <div class="row shadow p-3">
                <div class="col-2"></div>
                    <div class="col-lg-4 col-md-4 text-start">
                        <h3>{{ $seller->name }}</h3>
                        <span class="border p-1">lavel 1</span> <span class="text-muted">(0 XP)</span>
                        <h6 class="mt-3">Feedback Ratings</h6>
                        <strong class="float-start ">Quality : </strong>
                        {{-- <span style="font-size: 19px;"> ☆ ☆ ☆ ☆ ☆ </span> --}}
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
                        <br>
                        <strong class="float-start ">Shipping : </strong>
                        {{-- <span style="font-size: 19px;"> ☆ ☆ ☆ ☆ ☆ </span> --}}
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
                            {{-- <strong>☆ ☆ ☆ ☆ ☆</strong> --}}
                            <span style="font-size: 19px;"> ☆ ☆ ☆ ☆ ☆ </span>
                        @endif
                    </div>


                    <div class="col-lg-4 col-md-4 text-start">
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
                <div class="col-2"></div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-2"></div>
            {{-- <div class="col-8 text-start border p-1 bg-white"> <span class="cfs-12 text-muted">Member Since {{ date('M Y', strtotime( $seller->created_at)) }} | Vendor Since {{ date('M Y', strtotime( $seller->vendor_since)) }} | Disputes is last 12 months (Won 0/Losted 0) | Completed Orders: 0 | Rate Orders: 0</span></div> --}}
            <div class="col-8 text-start border p-1 bg-white">
                <span class="cfs-12 text-muted" style="display: flex; justify-content: space-around;">
                    Member Since {{ date('d M Y', strtotime( $seller->created_at)) }} |
                    Vendor Since {{ date('d M Y', strtotime( $seller->vendor_since)) }} |
                    Completed Orders: @if(isset($order_complete)) {{ count($order_complete) }} @endif |
                    Rate Orders: @if(isset($order_review)) {{ count($order_review) }} @endif
                </span>
            </div>
            <div class="col-2"></div>
        </div>



        <div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5">
            <div class="container mt-3">

                <ul class="nav nav-pills mb-3 d-inline-flex" id="pills-tab" role="tablist">
                    <li class="nav-item " role="presentation">
                        <button class="nav-link active border" id="pills-seller-about-tab" data-bs-toggle="pill" data-bs-target="#pills-seller-about"
                        type="button" role="tab" aria-controls="pills-seller-about" aria-selected="true">About</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link border" id="pills-total-product-tab" data-bs-toggle="pill" data-bs-target="#pills-all-products"
                        type="button" role="tab" aria-controls="pills-all-product" aria-selected="false">Item For Sale</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link border" id="pills-productFeedback-tab" data-bs-toggle="pill" data-bs-target="#pills-productFeedback"
                        type="button" role="tab" aria-controls="pills-productFeedback" aria-selected="false">All Feedbacks</button>
                    </li>
                </ul>


                <div class="tab-content" id="pills-tabContent">

                    <div class="tab-pane fade show active border p-3" id="pills-seller-about" role="tabpanel" aria-labelledby="pills-seller-about-tab">
                        <p class="text-start"> {!! $seller->about !!}</p>
                    </div>

                    <div class="tab-pane fade show border p-3" id="pills-all-products" role="tabpanel" aria-labelledby="pills-total-product-tab">
                        <div class="row">
                            @if(!empty($products))
                                @forelse ($products as $pro)

                                    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12">
                                        <div class="p-3 user-div shadow rounded">
                                            <div class="card mb-3">
                                                <div class="card-body" style=" max-height: 195px; ">
                                                    <div class="row g-0">
                                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-6">
                                                            <a href="{{ url('product-view',App\Models\Magician::ed($pro->id)) }}">
                                                                <img src="{{ asset('assets/images/product/'.$pro->image) }}" class="img-fluid" style=" max-height: 165px; " alt="...">
                                                            </a>
                                                        </div>
                                                        <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-5 col-sm-6">
                                                            <h5 class="card-title"> <a href="{{ url('product-view', App\Models\Magician::ed($pro->id)) }}" style="text-decoration: none; color:black">{{ $pro->name }}</a> </h5>
                                                            <p class="card-text text-muted " style="font-size: 13px">
                                                                @isset($pro->category->name)
                                                                    {{ $pro->category->name }}
                                                                @endisset
                                                                <br>
                                                                <span>Rating : </span>
                                                                @if($pro->reviews->avg('quality_review') != null)
                                                                    @switch($pro->reviews->avg('quality_review'))
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
                                                                @else
                                                                    <span style="font-size: 15px;"> ☆ ☆ ☆ ☆ ☆ </span>
                                                                @endif

                                                            </p>
                                                            <div class="card-text">
                                                                <small class="text-muted " style="font-size: 13px">
                                                                    @if($pro->auto_delivery == 1)
                                                                        Auto Delivery
                                                                        <br>
                                                                    @endif
                                                                    {{ $pro->qty }} Left/@if(isset($pro->order_count)) {{ $pro->order_count }} @else 0 @endif sold.
                                                                </small> <br>
                                                                <span class="fw-bold text-muted" style="font-size: 14px">Vendor :
                                                                <a href="{{ url('vendor-dashboard',App\Models\Magician::ed($pro->seller_id)) }}" class="text-decoration-none" style="color:#198754">
                                                                    @isset($pro->seller->name)
                                                                        {{ $pro->seller->name }}
                                                                    @endisset
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 ">
                                                            <div class="card-text ">
                                                                <small class="text-muted">
                                                                    <br>
                                                                    <br>
                                                                    <span class="fw-bold">Price : ${{ number_format($pro->price, 2) }}</span>
                                                                    <br>
                                                                    @if(Auth::user()->id != $pro->seller_id)
                                                                        <a class="text-decoration-none btn btn-outline-success btn-sm mt-2" onclick="buyNow({{ $pro->id }})">Buy Now</a>
                                                                    @endif
                                                                    @php
                                                                        $wishlisted = App\Models\Wishlist::where('product_id', $pro->id)->where('open_by', Auth::user()->id)->first();
                                                                    @endphp
                                                                    @if(@$wishlisted !=null)
                                                                        @if(@$wishlisted->product_id == $pro->id)
                                                                            <a class="text-decoration-none btn btn-outline-success btn-sm mt-2 active" title="Already Added To Wishlist" href="javascript:void(0)"><i class="fa-solid fa-heart text-danger"></i> Wishlist</a>
                                                                        @endif
                                                                        @else
                                                                            @if(Auth::user()->id != $pro->seller_id)
                                                                                <a class="text-decoration-none btn btn-outline-success btn-sm mt-2" title="Add To Wishlist" href="{{ url('add_to_wishlist',App\Models\Magician::ed($pro->id)) }}"><i class="fa-solid fa-heart text-danger"></i> Wishlist</a>
                                                                            @endif
                                                                    @endif
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @empty

                                    <div class="p-3 user-div shadow rounded">
                                        <div class="card mb-3">
                                            <div class="card-body" style=" max-height: 195px; ">
                                                <div class="row g-0">
                                                    <div class="col-xxl-12">
                                                        <span class="text-center">No Product Found</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            @endif
                        </div>
                    </div>

                    <div class="tab-pane fade show border p-3" id="pills-productFeedback" role="tabpanel" aria-labelledby="pills-productFeedback-tab">



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
        </div>


    </div>
@endsection
