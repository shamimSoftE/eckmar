@extends('FrontEnd.main')

@section('title', 'My Wallet')

@section('content')
<div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5">
    <!-- left side -->
    <div class="col-lg-3 col-md-2 text-start">
        <div class="shadow rounded">
            <div class="p-3">
                <h3 class="text-center">My Wallet</h3>
            </div>
            <div class="list-group rounded-0 border-0">
                <a href="javascript:void(0)" class="list-group-item fs-4 text-center"> Bitcoin</a>
                <a href="javascript:void(0)" class="list-group-item fs-4 text-center"> Monero</a>
                <a href="javascript:void(0)" class="list-group-item fs-4 text-center"> Dogecoin</a>
                {{-- <a href="#" class="list-group-item"> </a> --}}
            </div>
        </div>

    </div>

    <!-- right side top part -->
    <div class="col-lg-8 col-md-10 text-start">
        <div class="p-3 user-div shadow rounded">
            <div class="mb-4 text-capitalize inner-content">
                <p class="mb-1 border-bottom text-center">Info</p>
            </div>
        </div>
        <div class="p-3 user-div shadow rounded mt-3">
            <div class="mb-4 text-capitalize inner-content">
                <p class="mb-1 border-bottom text-center">Recive</p>
            </div>
        </div>
        <div class="p-3 user-div shadow rounded mt-3">
            <div class="mb-4 text-capitalize inner-content">
                <p class="mb-1 border-bottom text-center">Send</p>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 text-start">
        <div class="p-3 user-div shadow rounded mt-3">
            <div class="mb-4 text-capitalize inner-content">
                <p class="mb-1 border-bottom text-center">TX</p>
            </div>
        </div>
    </div>
</div>

@endsection
