@extends('FrontEnd.main')

@section('title', 'Edit Product')

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

        <div class="col-lg-10 col-md-10">

            <div class="user-div">
                <div class="shadow p-3">
                    <span class="text-center fs-19 fw-bold border-bottom">Product Update</span>

                    <div class="text-start">
                        <form method="POST" action="{{ url('product_update',App\Models\Magician::ed($product->id)) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $product->name }}" aria-describedby="name">
                                @error('name')
                                    <div id="name" class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="product_details" class="form-label">Product Details</label>
                                <textarea class="form-control @error('detail') is-invalid @enderror" name="detail" id="product_details" rows="5">{{ $product->detail }}</textarea>
                                @error('detail')
                                    <div id="product_name" class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="product_content" class="form-label">Product Content</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="product_content" rows="3">{{ $product->content }}</textarea>
                                @error('content')
                                    <div id="product_content" class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-xl-6 col-md-6">
                                            <div class="mb-3 d-flex">

                                                    <label for="productFile" class="form-label">Preview Image</label>
                                                    <img src="{{ asset('assets/images/product/'.$product->image) }}" class="rounded float-start" style="max-width: 120px" alt="">

                                                    &nbsp;&nbsp; <input class=" @error('image') is-invalid @enderror" type="file" accept="image/*" name="image" id="productFile">
                                                    @error('image')
                                                        <div id="productFile" class="form-text text-danger">{{ $message }}</div>
                                                    @enderror

                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-xl-6 col-md-6">
                                                    <div class="mb-3">
                                                        <label for="qty" class="form-label">Qty</label>
                                                        <input class="form-control @error('image') is-invalid @enderror" type="number" value="{{ $product->qty }}" name="qty" id="qty">
                                                        @error('qty')
                                                            <div id="qty" class="form-text text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xl-6 col-md-6">
                                                    <div class="mb-3">
                                                        <label for="price" class="form-label">Price</label>
                                                        <input class="form-control @error('image') is-invalid @enderror" value="{{ $product->price }}" type="text" name="price" id="price">
                                                        @error('price')
                                                            <div id="price" class="form-text text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-xl-6 col-md-6">
                                            <div class="mb-3">
                                                <label for="productFile" class="form-label">Product Category</label>
                                                <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" aria-label="Default select example">
                                                    <option value="">  select </option>
                                                    @foreach ($category as $item)
                                                        <option value="{{ $item->id }}" @if($product->category_id == $item->id) selected @endif>{{ $item->name }}</option>

                                                        @if(!empty(count($item->subCategories)))
                                                            @foreach ($item->subCategories as $subCat)
                                                                <option value="{{ $subCat->id }}" @if($product->category_id == $subCat->id) selected @endif>
                                                                    =>{{ $subCat->name }}
                                                                </option>

                                                                @if(!empty(count($subCat->subCategories)))
                                                                    @foreach ($subCat->subCategories as $ssCat)
                                                                        <option value="{{ $ssCat->id }}" @if($product->category_id == $ssCat->id) selected @endif>
                                                                            ===>{{ $ssCat->name }}
                                                                        </option>

                                                                        @if(!empty(count($ssCat->subCategories)))
                                                                            @foreach ($ssCat->subCategories as $sssCate)
                                                                                <option value="{{ $sssCate->id }}" @if($product->category_id == $sssCate->id) selected @endif>
                                                                                    ====>{{ $sssCate->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        @endif

                                                                    @endforeach
                                                                @endif

                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="form-text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" name="auto_delivery"  id="auto_delivery" value="1" @if($product->auto_delivery == 1) checked @endif>
                                                <label class="form-check-label" for="auto_delivery">Auto Delivery</label>
                                            </div>

                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" name="unlimited" id="unlimited" value="1" @if($product->unlimited == 1) checked @endif>
                                                <label class="form-check-label" for="unlimited">Unlimited</label>
                                            </div>
                                        </div>
                                    </div>
                                    <center> <button type="submit" class="btn btn-outline-success" style="width: 21%;">Update</button> </center>
                                </div>
                            </div>



                          </form>
                    </div>

                </div>
            </div>


        </div>


    </div>
@endsection
