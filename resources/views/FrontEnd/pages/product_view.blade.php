@extends('FrontEnd.main')

@section('title', 'Product Details')

@push('style')

<style>
    .circle {
        height: 55px;
        width: 55px;
        border: 1px solid #bbb;
        border-radius: 50%;
        display: inline-block;
    }
</style>

@endpush

@section('content')

        <div class="container mt-5 text-start">

            <div class="row g-2">

                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                    @if(isset($product->image) && $product->image !=null)
                        <img src="{{ asset('assets/images/product/'.$product->image) }}" style="height: 200px;float: right;padding: 0 20px 0 0;" class="rounded mx-auto d-block" alt="">
                    @else
                        {{-- <img src="{{ asset('assets/images/product/'.$product->image) }}" style="height: 200px;float: right;padding: 0 20px 0 0;" class="rounded mx-auto d-block" alt=""> --}}
                    @endif
                </div>

                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                    <span class="float-start"><strong>  Product</strong> <b> : </b> <span> <strong>{{ $product->name }} </strong> </span> </span><br/>
                    <span class="float-start"><strong>  Quality</strong> <b> : </b>
                        <span>
                            @if($product->reviews->avg('quality_review') != null)
                                @switch(number_format($product->reviews->avg('quality_review')))
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
                                {{-- <strong>☆ ☆ ☆ ☆ ☆</strong> --}}
                                <span style="font-size: 15px;"> ☆ ☆ ☆ ☆ ☆ </span>
                            @endif
                        </span>
                    </span><br/>
                    <span class="float-start"><strong>  Shipping</strong> <b> : </b>
                        <span>
                            @if($product->reviews->avg('shipping_review') != null)
                                @switch(number_format($product->reviews->avg('shipping_review')))
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
                                {{-- <strong>☆ ☆ ☆ ☆ ☆</strong> --}}
                            @endif
                        </span>
                    </span><br/>

                    <div class="float-start mt-1">
                        <p  style="font-size: 13px">
                            @if($product->auto_delivery == 1)
                                Auto Delivery
                                <br>
                            @endif
                            {{ $product->qty }} Left/@if(isset($product->order_count)) {{ $product->order_count }} @else 0 @endif sold.<br><br>
                            {{-- Auto Delivery <br> 14 left /937 sold<br><br> --}}
                            Price : ${{ number_format($product->price, 2) }} &nbsp; Qty  &nbsp;<input class="product_qty_{{ $product->id }}" type="number" style="width: 43px;padding: 0 0 0 9px;height: 31px;border: 1px solid #198754; border-radius: 3px;" value="1" minlength="1" maxlength="{{ $product->qty }}">

                            @if(Auth::user()->id != $product->seller_id) <a class="btn btn-sm btn-outline-success" onclick="buyNow({{ $product->id }})">Buy Now</a> @endif

                            @php
                                $wishlisted = App\Models\Wishlist::where('product_id', $product->id)->where('open_by', Auth::user()->id)->first();
                            @endphp
                            @if(@$wishlisted !=null)
                                @if(@$wishlisted->product_id == $product->id)
                                    <a class="btn btn-sm btn-outline-success active" title="Already Added To Wishlist" href="javascript:void(0)"><i class="fa-solid fa-heart text-danger"></i> Wishlist</a>
                                @endif
                            @else
                                @if(Auth::user()->id != $product->seller_id)
                                    <a class="btn btn-sm btn-outline-success" title="Add To Wishlist" href="{{ url('add_to_wishlist',App\Models\Magician::ed($product->id)) }}"><i class="fa-solid fa-heart text-danger"></i> Wishlist</a>
                                @endif
                            @endif
                        </p>
                    </div>
                </div>


                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <h6>Seller Info</h6>
                            <strong>
                                @isset($product->seller->name)
                                    {{ $product->seller->name }}
                                @endisset
                            </strong>
                            <div class="row border-bottom">
                                <div class="col-lg-4 col-md-4 mb-1">
                                    <div class="row">
                                        <div class="col-8"><span class="circle" style=" background: #198754;"></span></div>
                                        <div class="col-4 mt-2"><strong class="fs-3 text-center">@if(isset($order_feedback->review_positive)) {{ $order_feedback->review_positive }} @else{{ 0 }}@endif</strong></div>
                                    </div>
                                    <strong class="text-center">Positive</strong>
                                </div>
                                <div class="col-lg-4 col-md-4 mb-1">
                                    <div class="row ">
                                        <div class="col-8"><span class="circle" style="background: #f58020; "></span></div>
                                        <div class="col-4 mt-2"><strong class="fs-3 text-center">@if(isset($order_feedback->review_neutral)) {{ $order_feedback->review_neutral }} @else{{ 0 }}@endif</strong></div>
                                    </div>
                                    <strong class="text-center">Neutral</strong>
                                </div>
                                <div class="col-lg-4 col-md-4 mb-1">
                                    <div class="row">
                                        <div class="col-8"><span class="circle" style=" background:#d71616ed;"></span></div>
                                        <div class="col-4 mt-2"><strong class="fs-3 text-center">@if(isset($order_feedback->review_negative)) {{ $order_feedback->review_negative }} @else{{ 0 }}@endif</strong></div>
                                    </div>
                                    <strong class="text-center">Negative</strong>
                                </div>
                            </div>
                            <p class="p-3">
                                Shop with confidence, your order is Escow protected.
                            </p>
                        </div>
                    </div>
                </div>



                <div class="container mt-3">
                    <center>
                        <ul class="nav nav-pills mb-3 d-inline-flex" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-productDetails-tab" data-bs-toggle="pill" data-bs-target="#pills-productDetails"
                                type="button" role="tab" aria-controls="pills-productDetails" aria-selected="true">Product Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-productFeedback-tab" data-bs-toggle="pill" data-bs-target="#pills-productFeedback"
                                type="button" role="tab" aria-controls="pills-productFeedback" aria-selected="false">Product Feedbacks</button>
                            </li>
                        </ul>
                    </center>

                    <div class="tab-content" id="pills-tabContent">

                        <div class="tab-pane fade show active border p-3" id="pills-productDetails" role="tabpanel" aria-labelledby="pills-productDetails-tab">
                            <p>
                               {{ $product->detail }}
                               <br>
                               {{ $product->content }}
                            </p>
                        </div>

                        <div class="tab-pane fade show border p-3" id="pills-productFeedback" role="tabpanel" aria-labelledby="pills-productFeedback-tab">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-4">

                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-8"></div>
                            </div>


                            <div>
                                {{-- Average rating: {{ $product->reviews->avg('rating') }} --}}
                                <strong>Average Rating: </strong>
                                @if(!empty($product->reviews->avg('quality_review')))
                                    {{-- {{ dd( number_format($product->reviews->avg('quality_review')) ) }} --}}
                                    @switch(number_format($product->reviews->avg('quality_review')))
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

                                @if(!empty($product->reviews->avg('quality_review'))) <sup class="badge bg-danger">{{ number_format($product->reviews->avg('quality_review'),1) }}</sup> <br> <strong>Total Rating: </strong> <span class="badge bg-danger"> {{ count($product->reviews) }} </span> @endif

                                <br>
                            </div>

                            <ul style=" max-height: 481px; overflow-y: scroll; padding: 5px;">
                                @if($product->reviews !=null)

                                    @foreach ($product->reviews as $key=> $review)
                                    {{-- {{ dd($review) }} --}}
                                        <li style=" margin-bottom: 9px;">
                                           <span class="text-capitalize"> <strong>{{ ++$key }}.</strong>  {{ $review->feedback_message }}</span>
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
                                            <span class="text-muted" style=" font-size: 13px; "> Reviewer: </span> @if($review->customer->name !=null) {{ $review->customer->name }} @endif
                                        </li>
                                    @endforeach
                                @endif
                            </ul>


                        </div>
                    </div>
                </div>

            </div>
        </div>


        {{-- buy_now modal --}}
        <div class="modal fade" id="buy_now_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="buy_now_modalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="buy_now_modalLabel">Your preferable Currency</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('buy_product') }}" class="buy_now_form" autocomplete="off" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3 text-start">
                            <label for="" class="pull-left mb-2"><small>Choose Currency</small></label>
                            <select name="currency" class="form-control">
                                {{-- @foreach ($categorys as $cate) --}}
                                    {{-- <option value="{{ $cate->id }}">{{ $cate->name }}</option> --}}
                                    <option value="btc">{{ __('BTC') }}</option>
                                    <option value="xmr">{{ __('XMR') }}</option>
                                    <option value="dollar">{{ __('Dollar') }}</option>
                                    <option value="dogo">{{ __('DOGO') }}</option>
                                {{-- @endforeach --}}
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="product_id">
                        <input type="hidden" name="product_qty">
                        <button type="submit" class="blue-shadow-button bg-success" style="border: none;color:white; padding: .5em 1.2em !important;">Confirm</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        {{-- buy_now modal --}}

@endsection

@push('script')
    <script>
        function buyNow(id) {
            var qty = $(".product_qty_"+id).val();
            $(".buy_now_form [name=product_id]").val(id);
            $(".buy_now_form [name=product_qty]").val(qty);
            $("#buy_now_modal").modal('show');
        }
    </script>
@endpush
