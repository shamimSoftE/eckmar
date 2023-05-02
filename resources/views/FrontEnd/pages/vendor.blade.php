@extends('FrontEnd.main')

@section('title', 'Vendor')

@section('content')
<div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5">
    <!-- left side -->


    <!-- right side top part -->
    <div class="col-lg-12 col-md-12 text-start">
        <form action="{{ url('vendor_request_form') }}" method="POST">
            @csrf
            <div class="p-3 user-div shadow rounded">
                <div class="mb-4  inner-content">
                    <h3 class="mb-3">Become A Vendor</h3>
                    <div class="mb-3 border p-3">
                        <p class="fs-6" style="font-size: 12px!important;">Become a Vendor on this market and you will have access to post products that you want to sell.</p>
                        <p class="fs-6" style="font-size: 12px!important;">To become a vendor you must pay vendor fee in amount of <strong>100 USD</strong> to the one of the following address.</p>
                    </div>
                    <center>
                        <button type="submit" class="btn btn-outline-success">Become A Vendor</button>
                    </center>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
