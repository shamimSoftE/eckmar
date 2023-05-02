@extends('FrontEnd.main')

@section('title', 'Order Processing')

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
                        <a class="nav-link bg-success text-white active rounded" aria-current="page" href="#">Processing</a>
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
                        <a class="nav-link" href="{{ url('order-view') }}">Completed</a>
                      </li>
                    </ul>
                  </div>
                </div>
            </nav>



            <div class="tab-pane fade show active" id="pills-process" role="tabpanel" aria-labelledby="pills-process-tab">

                <div class="row justify-content-between mt-5 mb-5">
                    <div class="col-sm-4 col-md-4 col-lg-4"></div>
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <span class="float-start"><strong>  Product</strong> <b> : </b> <span> <strong>{{ $product->name}} </strong> </span> </span><br/>
                        <span class="float-start"><strong>  Price</strong> <b> : </b> <span> <strong>${{ number_format($product->price) }}</strong> </span> </span><br/>
                        <span class="float-start"><strong>  Qty</strong> <b> : </b> <span> <strong>{{ $order->product_qty }} </strong></span> </span><br/>
                        <span class="float-start"><strong>  Total Price</strong>  <b> : </b> <span> <strong>${{ $order->product_qty * $product->price }}</strong> </span> </span><br/>
                        <span class="float-start"><strong>  Vendor</strong> <b> : </b> <span> <strong>@if($product->seller->name) {{ $product->seller->name }} @endif</strong></span> </span><br/>
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
                    <div class="col-sm-4 col-md-4 col-lg-4"></div>
                    <div class="col-sm-4 col-md-4 col-lg-4 mt-5">
                        <p style="">If vendor does not delive within 24hrs this order will get cancel auto or you can cancel it anytime within 24hrs.</p>
                        <br/>
                        {{-- <a href="javascript:void(0)" class="btn btn-outline-danger">Cancel Order</a> --}}
                        <form method="POST" action="{{ url('/order_cancel',App\Models\Magician::ed($order->id)) }}">
                            @csrf
                                &nbsp;<button type="submit" class="btn btn-outline-danger" data-toggle="tooltip" title='Cancel'>
                                    Cancel Order
                            </button>
                        </form>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4"></div>
                </div>

            </div>

        </div>
    </div>
@endsection
