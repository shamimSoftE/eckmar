@extends('FrontEnd.main')

@section('title', 'Order Completed')

@push('style')

<style>
     /* css for review */
     .active-review span {
        pointer-events: none;
    }
    .active-review a {
        pointer-events: none;
    }
    .review-section {
        display: none;
        z-index: 999;
    }
    .review {
        float: left;
        height: 46px;
        padding: 0 10px;
    }
    .review input {
        display: none;
    }
    .review:not(:checked) > input {
        position:absolute;
    }
    .review:not(:checked) > label {
        float:right;
        width:1em;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px;
        color:#ccc;
    }
    .review:not(:checked) > label:before {
        content: '★ ';
    }
    .review > input:checked ~ label {
        color: #f58020 ;
    }
    .review:not(:checked) > label:hover,
    .review:not(:checked) > label:hover ~ label {
        color: #f58020 ;
    }
    .review > input:checked + label:hover,
    .review > input:checked + label:hover ~ label,
    .review > input:checked ~ label:hover,
    .review > input:checked  label:hover  label,
    .review > label:hover  input:checked  label {
        color: #f58020 ;
    }
    a{
        text-decoration: none;
    }

    .review > input:checked ~ label {
        color: #f58020 ;
    }
</style>

@endpush

@section('content')

    <div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5">
        <div class="container mt-3">

            <nav class="navbar navbar-expand-lg bg-body-tertiary d-inline-flex border">
                <div class="container-fluid">
                  <a class="navbar-brand text-success" href="#">Status</a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ">
                      <li class="nav-item">
                        <a class="nav-link" href="{{ url('order-view') }}">Processing</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="{{ url('order-view') }}">Delivered</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="{{ url('order-view') }}">Dispute</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="{{ url('order-view') }}">Canceled</a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link bg-success text-white active rounded" aria-current="page" href="#">Completed</a>
                      </li>
                    </ul>
                  </div>
                </div>
            </nav>





            <div class="row justify-content-between mt-5 mb-5">
                <div class="col-sm-4 col-md-4 col-lg-4"></div>
                <div class="col-sm-3 col-md-3 col-lg-3">
                    <span class="float-start"><strong>  Product</strong> <b> : </b> <span> <strong>{{ $product->name }} </strong> </span> </span><br/>
                    <span class="float-start"><strong>  Price</strong> <b> : </b> <span> <strong>${{ number_format($product->price) }}</strong> </span> </span><br/>
                    <span class="float-start"><strong>  Qty</strong> <b> : </b> <span> <strong>{{ $order->product_qty }} </strong></span> </span><br/>
                    <span class="float-start"><strong>  Total Price</strong>  <b> : </b> <span> <strong>${{ number_format($product->price *$order->product_qty ) }}</strong> </span> </span><br/>
                    <span class="float-start"><strong>  Vendor</strong> <b> : </b> <span> <strong>@if(isset($product->seller->name)) {{ $product->seller->name }} @endif</strong></span> </span><br/>
                    <span class="float-start"><strong>  Created</strong> <b> : </b> <span> <strong>{{ date('d/m/Y H:i:A', strtotime($order->created_at)) }}</strong> </span> </span>
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3">
                    @if(isset($product->image))
                        <img src="{{ asset('assets/images/product/'.$product->image) }}" style="height: 153px;float: left;" class="rounded mx-auto d-block" alt="...">
                        @else
                        <img src="{{ asset('assets/uploads/product/gift-card.png') }}" style="height: 153px;float: left;" class="rounded mx-auto d-block" alt="...">
                    @endif
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2"></div>



                <div class="col-sm-3 col-md-3 col-lg-3"></div>
                <div class="col-sm-6 col-md-6 col-lg-6 mt-5">
                    <div class="mb-3">
                        <span style="float: left;padding: 0;" class="text-success">Delivery : </span>
                        <div class="mt-3 p-3 border text-start" style=" margin-top: 21px!important; ">
                            {{-- product autofill data = content --}}
                            {{ $product->content }}
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3"></div>
            </div>


            {{-- order feedback --}}

            <form action="{{ url('order_feedback') }}" method="POST">
                @csrf
                <div class="row mt-5">
                    <div class="col-3"></div>
                    <div class="col-2">
                        <strong class="float-start mt-2 mb-2">How was your experience?</strong>
                    </div>
                    <div class="col-4">
                        <label for="positive" class="btn btn-sm btn-outline-success">Positive</label>
                        <label for="neutral" class="btn btn-sm btn-outline-primary m-2">Neutral</label>
                        <label for="negetive" class="btn btn-sm btn-outline-warning ">Negetive</label>
                        <div class="row">
                            <div class="col-4">
                                <input class="form-check-input" type="radio" name="review_button" id="positive" style=" float: right!important;" value="1" checked>
                            </div>
                            <div class="col-4">
                                <input class="form-check-input" type="radio" name="review_button" id="neutral" value="2">
                            </div>
                            <div class="col-4">
                                <input class="form-check-input" type="radio" name="review_button" id="negetive" style=" float: left!important;" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="col-3"></div>
                    <input type="hidden" name="product_id" value=" {{ $product->id }}">
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div class="col-3"></div>
                    <div class="col-2">
                        {{-- <strong class="text-center ">Quality : <span style="font-size: 19px;"> ☆ ☆ ☆ ☆ ☆ </span> </strong>
                        <strong class="float-start ">Shipping : <span style="font-size: 19px;"> ☆ ☆ ☆ ☆ ☆ </span> </strong> --}}

                        <strong class="float-start">Quality : </strong>
                        <div class="review d-block float-start">
                            <input type="radio" id="star5" name="quality_review" value="5" checked>
                            <label for="star5" title="5">5 stars</label>
                            <input type="radio" id="star4" name="quality_review" value="4">
                            <label for="star4" title="4">4 stars</label>
                            <input type="radio" id="star3" name="quality_review" value="3">
                            <label for="star3" title="3">3 stars</label>
                            <input type="radio" id="star2" name="quality_review" value="2">
                            <label for="star2" title="2">2 stars</label>
                            <input type="radio" id="star1" name="quality_review" value="1">
                            <label for="star1" title="1">1 star</label>
                        </div>

                        <strong class="float-start">Shipping : </strong>
                        <div class="review d-block float-start">
                            <input type="radio" id="star6" name="shipping_review" value="5" checked>
                            <label for="star6" title="5">5 stars</label>
                            <input type="radio" id="star7" name="shipping_review" value="4">
                            <label for="star7" title="4">4 stars</label>
                            <input type="radio" id="8" name="shipping_review" value="3">
                            <label for="8" title="3">3 stars</label>
                            <input type="radio" id="star9" name="shipping_review" value="2">
                            <label for="star9" title="2">2 stars</label>
                            <input type="radio" id="star10" name="shipping_review" value="1">
                            <label for="star10" title="1">1 star</label>
                        </div>
                    </div>
                    <div class="col-4">
                    <div class="mt-3"> <span class="d-flex">Tell Us More:</span>
                        <span> <textarea name="feedback_message" cols="10" rows="3" class="form-control"></textarea> </span>
                        {{-- <span> <input type="text" name="" class="p-1"> </span> --}}
                    </div>
                    </div>
                    <div class="col-3"></div>

                </div>
                <center> <button type="submit" class="btn btn-sm btn-outline-success mt-3">Leave FeedBack</button> </center>
            </form>

        </div>
    </div>
@endsection

@push('script')

<script>
    // js for review
    // $('.review-ticket').click(function(){
    //     $('body').addClass('active-review');
    //     $('.review-section').show();
    //     $('html, body').animate({
    //         scrollTop: $('.review-section').offset().top - 100
    //     }, 10);
    // })
</script>

@endpush
