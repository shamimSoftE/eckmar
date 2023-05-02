@extends('FrontEnd.main')

@section('title', 'Product-Filter')

@section('content')
    <div class="row g-2 justify-content-between mb-3 mx-0 px-5">
        <div class="col-12 shadow mb-3">
            <nav class="navbar navbar-light bg-light">
                <div class="container-fluid">
                  {{-- <a class="navbar-brand">Navbar</a> --}}
                  <form class="" method="get" action="{{ url('product-filter') }}">
                    @csrf
                    <div class="row">

                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
                            <div class="">
                                <input type="text" name="product_name" class="form-control" placeholder="Keyword">
                            </div>
                        </div>
                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-6">
                            <div class="d-flex">
                                <input type="text" class="form-control me-1" name="min_price" placeholder="$ min">

                                <input type="text" class="form-control" name="max_price" placeholder="$ max">
                            </div>
                        </div>

                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-6 col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" name="auto_delivery" type="checkbox" value="1" id="auto_delivery" >
                                <label class="form-check-label" for="auto_delivery">
                                  Auto delivery
                                </label>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 d-flex">

                            <select class="form-select form-select-sm me-2" aria-label="Default select example" name="low_high">
                                <option value="">Select</option>
                                <option value="1">Lowest Price</option>
                                <option value="2">Highest Price</option>
                            </select>

                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success btn-sm" type="submit">Search</button>
                        </div>
                    </div>

                  </form>
                </div>
              </nav>
        </div>

        <!-- left side -->
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-2 col-sm-12 text-start">
            <div class="shadow rounded">
                <div class="text-center bg-success text-white py-2 rounded-top">
                    <h3>Category</h3>
                </div>
                <div class="list-group rounded-0 border-0" style="overflow-x: scroll; max-height: 349px;">
                    @foreach ($data['category'] as $cate)
                        <a href="{{ url('category-wise', $cate->slug) }}" class="list-group-item @if(request()->segment(2) == $cate->slug) c_active @endif"> {{ $cate->name }} </a>
                    @endforeach

                </div>
            </div>

            <!-- company mirror -->
            <div class="mt-5 mirror shadow rounded">
                <h3 class="text-capitalize text-success text-center py-3">
                Mirror Links
                </h3>
                <div class="list-group rounded-0" style=" overflow-x: scroll; max-height: 349px; ">
                    @if(isset($data['m_links']))
                        @foreach ($data['m_links'] as $key=> $link)
                            <a href="{{ $link->link }}" target="_blank" class="list-group-item  border-0" title="{{ $link->link }}"> {{ ++$key }}. <u>{{ $link->title }}</u> </a>
                        @endforeach
                    @endif
                </div>
                {{-- <div class="p-3 img-container rounded-bottom">
                    <div class="mb-4 text-capitalize inner-content">
                    </div>
                </div> --}}

            </div>
        </div>

        <!-- right side top part -->
        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-10 col-sm-12 text-start">
            @if(!empty($data['products']))
                @forelse ($data['products'] as $pro)

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
                                                @switch(number_format($pro->reviews->avg('quality_review')))
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

                <button type="submit" class="blue-shadow-button bg-success" style="border: none;color:white; padding: .5em 1.2em !important;">Confirm</button>
            </div>
            <input type="hidden" name="product_id">
            <input type="hidden" name="product_qty">
        </form>
      </div>
    </div>
  </div>
{{-- buy_now modal --}}

@endsection

@push('script')
    <script>
        function buyNow(id) {
            var qty = 1;
            $(".buy_now_form [name=product_id]").val(id);
            $(".buy_now_form [name=product_qty]").val(qty);

            $("#buy_now_modal").modal('show');
        }
    </script>
@endpush
