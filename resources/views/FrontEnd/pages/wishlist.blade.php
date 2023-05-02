@extends('FrontEnd.main')

@section('title', 'All-Wishlist')

@push('style')
    <style>
        .wish_btn{
            text-decoration: none!important;
        }
        .wish_btn:hover{
            color: white!important;
        }
    </style>

@endpush

@section('content')

<div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5">

    <div class="col-lg-12 col-md-12 text-start">
        <div class="p-3 user-div shadow rounded">
            <div class="mb-4 text-capitalize inner-content">
                <h3 class="mb-2">Wishlist</h3>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Time</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if(isset($wishlist))
                                @foreach ($wishlist as $key => $wish)
                                {{-- {{ dd($wish->product) }} --}}
                                    <tr>
                                        <th scope="row">{{ ++$key }}</th>
                                        @if(isset($wish->product))
                                            <td>
                                                <div class="row">
                                                    <div class="col-4">
                                                        {{ $wish->product->name  }}
                                                    </div>
                                                    <div class="col-8">
                                                        @if(isset($wish->product->image) && $wish->product->image !=null)
                                                            <img src="{{ asset('assets/images/product/'.$wish->product->image) }}" style="height:30px;" alt="">
                                                        @else
                                                            {{-- <img src="{{ asset('assets/images/product/'.$product->image) }}" style="height: 200px;float: right;padding: 0 20px 0 0;" class="rounded mx-auto d-block" alt=""> --}}
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td><small>${{ $wish->product->price }}</small></td>
                                            <td><small>{{ $wish->created_at->diffForHumans() }}</small></td>
                                            @else
                                            <td>{{ __('N/A')  }}</td>
                                            <td><small>{{ __('N/A') }}</small></td>
                                        @endif
                                        <td>
                                            <a class="btn btn-sm btn-outline-success wish_btn text-dark" onclick="buyNow({{ $wish->product_id }})">Buy Now</a>
                                            <a href="{{ url('wishlist_remove', App\Models\Magician::ed($wish->id)) }}" class="btn btn-outline-danger btn-sm text-dark wish_btn">Remove &nbsp; &nbsp;<i class="fa-solid fa-times"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                      </table>
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
            $(".buy_now_form [name=product_id]").val(id);
            $(".buy_now_form [name=product_qty]").val(1);
            $("#buy_now_modal").modal('show');
        }
    </script>
@endpush
