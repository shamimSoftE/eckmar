@extends('FrontEnd.main')

@section('title', 'Autofill Add')

@push('style')

<style>
 .c_active{ color: #ffffff!important; background-color: #198754; }
</style>

@endpush

@section('content')

    <div class="row justify-content-between mt-5 mb-3 mx-0 px-5">

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

        <div class="col-lg-1 col-md-1"></div>
        <div class="col-lg-6 col-md-6">

            <div class="user-div">
                <div class="shadow p-3">



                    <div class="text-start">
                        <form method="POST" action="{{ url('add_more_autofill',App\Models\Magician::ed($product->id)) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">

                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-xl-4"><strong>{{ $product->name }}</strong></div>
                                    <div class="col-xl-4"><strong>@if(!empty( $product->category->name)){{ $product->category->name }} @endif</strong></div>
                                    <div class="col-xl-4"><strong>{{ $product->qty }} Left / 00 Sold</strong></div>
                                </div>
                                <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="product_content" rows="3">{{ $product->content }}</textarea>
                                @error('content')
                                    <div id="product_content" class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <center> <button type="submit" class="btn btn-outline-success" style="width: 21%;">Add</button> </center>
                          </form>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3"></div>


    </div>
@endsection
