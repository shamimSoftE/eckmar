@extends('FrontEnd.main')

@section('title', 'Auto Delivery')

@section('content')
    <div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5">
        <div class="container mt-3">
            <ul class="nav nav-pills mb-3 d-inline-flex" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-status-tab" data-bs-toggle="pill" data-bs-target="#pills-status" type="button" role="tab" aria-controls="pills-status" aria-selected="true">Status</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Processing</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Delivered</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Dispute</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Cancelled</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-status" role="tabpanel" aria-labelledby="pills-status-tab">

                    <div class="row justify-content-between mt-3 mb-5">

                        <div class="col-sm-4 col-md-4 col-lg-4"></div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <span class="float-start"><strong>  Product</strong> <b> : </b> <span> <strong>Keycode </strong> </span> </span><br/>
                            <span class="float-start"><strong>  Price</strong> <b> : </b> <span> <strong>$0.43</strong> </span> </span><br/>
                            <span class="float-start"><strong>  Qty</strong> <b> : </b> <span> <strong>1 </strong></span> </span><br/>
                            <span class="float-start"><strong>  Total</strong> Price <b> : </b> <span> <strong>$0.43</strong> </span> </span><br/>
                            <span class="float-start"><strong>  Vendor</strong> <b> : </b> <span> <strong>Fatkid </strong></span> </span><br/>
                            <span class="float-start"><strong>  Created</strong> <b> : </b> <span> <strong>2022-01-21 19:00:21</strong> </span> </span>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <img src="{{ asset('assets/uploads/product/gift-card.png') }}" style="height: 153px;float: left;" class="rounded mx-auto d-block" alt="...">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2"></div>
                    </div>

                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">

                </div>
            </div>
        </div>
    </div>
@endsection

