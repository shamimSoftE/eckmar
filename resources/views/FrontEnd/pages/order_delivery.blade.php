@extends('FrontEnd.main')

@section('title', 'Order Shipped')

@push('style')

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
                        <a class="nav-link bg-success text-white active rounded" aria-current="page" href="#">Shipped</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="{{ url('order-view') }}">Dispute</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="{{ url('order-view') }}">Canceled</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="{{ url('order-view') }}">Completed</a>
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

            {{-- <div class="row mt-5">
                <div class="col-3"></div>
                <div class="col-2">
                    <strong class="float-start mt-2">How was your experience?</strong>
                </div>
                <div class="col-4">
                    <button type="button" class="btn btn-outline-success">Positive</button>
                    <button type="button" class="btn btn-outline-primary m-2">Neutral</button>
                    <button type="button" class="btn btn-outline-warning ">Negetive</button>
                </div>
                <div class="col-3"></div>

                <div class="col-3"></div>
                <div class="col-2">
                    <strong class="float-start ">Quality : <span style="font-size: 19px;"> ☆ ☆ ☆ ☆ ☆ </span> </strong>
                    <strong class="float-start ">Shipping : <span style="font-size: 19px;"> ☆ ☆ ☆ ☆ ☆ </span> </strong>
                </div>
                <div class="col-4">
                   <div class="mt-3"> <span>Tell Us More:</span> <span> <input type="text" name="" class="p-1"> </span></div>
                </div>
                <div class="col-3"></div>
                <center> <a href="" class="btn btn-outline-success mt-5">Leave FeedBack</a> </center>
            </div> --}}

        </div>
    </div>
@endsection
