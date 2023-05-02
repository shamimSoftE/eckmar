@extends('FrontEnd.main')

@section('title', 'My Orders')

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
                    <ul class="nav nav-pills mb-3 d-inline-flex" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-allOrder-tab" data-bs-toggle="pill" data-bs-target="#pills-allOrder" type="button" role="tab" aria-controls="pills-allOrder" aria-selected="true">All</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-process-tab" data-bs-toggle="pill" data-bs-target="#pills-process" type="button" role="tab" aria-controls="pills-process" aria-selected="false">Processing</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-delivered-tab" data-bs-toggle="pill" data-bs-target="#pills-delivered" type="button" role="tab" aria-controls="pills-delivered" aria-selected="false">Shipped</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-dispute-tab" data-bs-toggle="pill" data-bs-target="#pills-dispute" type="button" role="tab" aria-controls="pills-dispute" aria-selected="false">Dispute</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-cancel-tab" data-bs-toggle="pill" data-bs-target="#pills-cancel" type="button" role="tab" aria-controls="pills-cancel" aria-selected="false">Cancelled</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-complete-tab" data-bs-toggle="pill" data-bs-target="#pills-complete" type="button" role="tab" aria-controls="pills-complete" aria-selected="false">Completed</button>
                        </li>
                    </ul>



                    <div class="tab-content" id="pills-tabContent">

                        <div class="tab-pane fade show active" id="pills-allOrder" role="tabpanel" aria-labelledby="pills-allOrder-tab">
                            {{-- order-status sms --}}
                                <div class="alert alert-success order_status_sms" style="display: none;" role="alert">

                                </div>
                            {{-- end --}}

                            <table class="table table-border table-hover mt-5" style="height: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Vendor</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data['orders'] as $order)
                                        @php
                                            $product = App\Models\Product::find($order->product_id);
                                            $vendor = App\Models\User::find($order->seller_id);
                                        @endphp
                                        <tr>
                                            <td>
                                                @switch($order->status)
                                                    @case(0)
                                                        <span>{{ $order->custom_order_id }}</span>
                                                        @break
                                                    @case(1)
                                                             <span>{{ $order->custom_order_id }}</span>
                                                        @break
                                                    @case(2)
                                                             <span>{{ $order->custom_order_id }}</span>
                                                        @break
                                                    @case(3)
                                                        <a href="{{ url('/order-dispute', App\Models\Magician::ed($order->id)) }}" class="text-muted">{{ $order->custom_order_id }}</a>
                                                        @break
                                                    @default
                                                         <span>{{ $order->custom_order_id }}</span>
                                                @endswitch
                                            </td>
                                            <td>@if(isset($product->name)) {{ $product->name }} @endif</td>
                                            <td> {{ $order->product_qty }} </td>
                                            <td>@if(isset($vendor->name)) {{ $vendor->name }} @endif</td>
                                            <td>
                                                @switch($order->status)
                                                    @case(0)
                                                        <span class="badge bg-primary">Process</span>
                                                        @break
                                                    @case(1)
                                                        <span class="badge bg-secondary">Completed</span>
                                                        @break
                                                    @case(2)
                                                        <span class="badge bg-success">Shipped</span>
                                                        @break
                                                    @case(3)
                                                        <span class="badge bg-warning">Disputes</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-danger">Canceled</span>
                                                @endswitch
                                            </td>
                                            <td>@if(isset($product->price)) {{ number_format($order->product_qty * $product->price) }} @endif</td>
                                            <td>{{ date('dS, M - Y', strtotime($order->created_at)).' '. date('h:i:A', strtotime($order->created_at)) }}</td>
                                            <td>
                                                @if($order->status == 1 || $order->status == 4)
                                                @else
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Order Status
                                                        </button>

                                                        <ul class="dropdown-menu">

                                                            @if( $order->status != 0)
                                                                <li><a class="dropdown-item text-primary" href="javascript:void(0)" onclick="order_status({{ $order->id }}, 0)">Process </a></li>
                                                            @endif

                                                            @if( $order->status != 1)
                                                                <li><a class="dropdown-item text-secondary" href="javascript:void(0)" onclick="order_status({{ $order->id }}, 1)">Complete </a></li>
                                                            @endif

                                                            @if( $order->status != 2)
                                                                <li><a class="dropdown-item text-success" href="javascript:void(0)" onclick="order_status({{ $order->id }}, 2)">Shipped </a></li>
                                                            @endif

                                                            {{-- @if( $order->status != 3)
                                                                <li><a class="dropdown-item text-warning" href="javascript:void(0)" onclick="order_status({{ $order->id }}, 3)">Disputes </a></li>
                                                            @endif --}}

                                                            @if($order->status == 1 || $order->status == 4)
                                                            @else
                                                                <li>
                                                                    {{-- <a class="dropdown-item text-danger" href="{{ url('/order_cancel',App\Models\Magician::ed($order->id)) }}">Cancelled </a> --}}
                                                                    <form method="POST" action="{{ url('/order_cancel',App\Models\Magician::ed($order->id)) }}">
                                                                        @csrf
                                                                            <button type="submit" class="btn text-danger show_confirm" data-toggle="tooltip" title='Cancel'>
                                                                            {{-- <i class="fa-solid fa-times"></i> --}}
                                                                            Cancelled
                                                                        </button>

                                                                    </form>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                @endif
                                                {{-- <a href="" class="text-danger"><i class="fa-solid fa-trash"></i></a> --}}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">You Don't Have Any Order Yet!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- pagination --}}
                            {{ $data['orders']->links() }}
                        </div>


                        <div class="tab-pane fade show" id="pills-process" role="tabpanel" aria-labelledby="pills-process-tab">

                            <table class="table table-border table-hover mt-5" style="height: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Vendor</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data['order_process'] as $order_pro)
                                        @php
                                            $product = App\Models\Product::find($order_pro->product_id);
                                            $vendor = App\Models\User::find($order_pro->seller_id);
                                        @endphp
                                        <tr>
                                            <td>
                                                <a href="{{ url('/order-process') }}" class="text-muted">{{ $order_pro->custom_order_id }}</a>
                                            </td>
                                            <td>@if(isset($product->name)) {{ $product->name }} @endif</td>
                                            <td> {{ $order_pro->product_qty }} </td>
                                            <td>@if(isset($vendor->name)) {{ $vendor->name }} @endif</td>
                                            <td><span class="badge bg-primary">Process</span></td>
                                            <td>@if(isset($product->price)) ${{ number_format($order_pro->product_qty * $product->price) }} @endif</td>
                                            <td>{{ date('dS, M - Y', strtotime($order_pro->created_at)).' '. date('h:i:A', strtotime($order_pro->created_at)) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">You Don't Have Any Order Yet!</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>

                            {{-- pagination --}}
                            {{ $data['order_process']->links() }}
                        </div>

                        <div class="tab-pane fade" id="pills-delivered" role="tabpanel" aria-labelledby="pills-delivered-tab">
                            <table class="table table-border table-hover mt-5" style="height: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Vendor</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data['order_delivered'] as $order_deli)
                                        @php
                                            $product = App\Models\Product::find($order_deli->product_id);
                                            $vendor = App\Models\User::find($order_deli->seller_id);
                                        @endphp
                                        <tr>
                                            <td>
                                                <a href="{{ url('/order-delivered') }}" class="text-muted">{{ $order_deli->custom_order_id }}</a>
                                            </td>
                                            <td>@if(isset($product->name)) {{ $product->name }} @endif</td>
                                            <td> {{ $order_deli->product_qty }} </td>
                                            <td>@if(isset($vendor->name)) {{ $vendor->name }} @endif</td>
                                            <td><span class="badge bg-success">Shipped</span></td>
                                            <td>@if(isset($product->price)) ${{ number_format($order_deli->product_qty * $product->price) }} @endif</td>
                                            <td>{{ date('dS, M - Y', strtotime($order_deli->created_at)).' '. date('h:i:A', strtotime($order_deli->created_at)) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">You Don't Have Any Order Yet!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{-- pagination --}}
                            {{ $data['order_delivered']->links() }}
                        </div>


                        <div class="tab-pane fade" id="pills-dispute" role="tabpanel" aria-labelledby="pills-dispute-tab">
                            <table class="table table-border table-hover mt-5" style="height: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Vendor</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($data['order_disputes'] as $order_dis)
                                        @php
                                            $product = App\Models\Product::find($order_dis->product_id);
                                            $vendor = App\Models\User::find($order_dis->seller_id);
                                        @endphp
                                        <tr>
                                            <td>
                                                <a href="{{ url('/order-dispute') }}" class="text-muted">{{ $order_dis->custom_order_id }}</a>
                                            </td>
                                            <td>@if(isset($product->name)) {{ $product->name }} @endif</td>
                                            <td> {{ $order_dis->product_qty }} </td>
                                            <td>@if(isset($vendor->name)) {{ $vendor->name }} @endif</td>
                                            <td><span class="badge bg-warning">Disputes</span></td>
                                            <td>@if(isset($product->price)) ${{ number_format($order_dis->product_qty * $product->price) }} @endif</td>
                                            <td>{{ date('dS, M - Y', strtotime($order_dis->created_at)).' '. date('h:i:A', strtotime($order_dis->created_at)) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">You Don't Have Any Order Yet!</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>

                            {{-- pagination --}}
                            {{ $data['order_disputes']->links() }}
                        </div>


                        <div class="tab-pane fade" id="pills-cancel" role="tabpanel" aria-labelledby="pills-cancel-tab">

                            <table class="table table-border table-hover mt-5" style="height: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Vendor</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        {{-- <th>Cancel Reason</th> --}}
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($data['order_cancell'] as $order_cancell)
                                        @php
                                            $product = App\Models\Product::find($order_cancell->product_id);
                                            $vendor = App\Models\User::find($order_cancell->seller_id);
                                        @endphp
                                        <tr>
                                            <td>
                                                <a href="{{ url('/order-cancelled') }}" class="text-muted">{{ $order_cancell->custom_order_id }}</a>
                                            </td>
                                            <td>@if(isset($product->name)) {{ $product->name }} @endif</td>
                                            <td> {{ $order_cancell->product_qty }} </td>
                                            <td>@if(isset($vendor->name)) {{ $vendor->name }} @endif</td>
                                            <td><span class="badge bg-danger">Cancelled</span></td>
                                            <td>@if(isset($product->price)) ${{ number_format($order_cancell->product_qty * $product->price) }} @endif</td>
                                            {{-- <td>lorem ipsum dollar summmit...</td> --}}
                                            <td>{{ date('dS, M - Y', strtotime($order_cancell->created_at)).' '. date('h:i:A', strtotime($order_cancell->created_at)) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">You Don't Have Any Order Yet!</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>

                            {{-- pagination --}}
                            {{ $data['order_cancell']->links() }}
                        </div>

                        <div class="tab-pane fade" id="pills-complete" role="tabpanel" aria-labelledby="pills-complete-tab">
                            <table class="table table-border table-hover mt-5" style="height: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Vendor</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data['order_complete'] as $order_complete)
                                        @php
                                            $product = App\Models\Product::find($order_complete->product_id);
                                            $vendor = App\Models\User::find($order_complete->seller_id);
                                        @endphp
                                        <tr>
                                            <td>
                                                <a href="{{ url('/order-complete') }}" class="text-muted">{{ $order_complete->custom_order_id }}</a>
                                            </td>
                                            <td>@if(isset($product->name)) {{ $product->name }} @endif</td>
                                            <td> {{ $order_complete->product_qty }} </td>
                                            <td>@if(isset($vendor->name)) {{ $vendor->name }} @endif</td>
                                            <td><span class="badge bg-secondary">Completed</span></td>
                                            <td>@if(isset($product->price)) ${{ number_format($order_complete->product_qty * $product->price) }} @endif</td>
                                            <td>{{ date('dS, M - Y', strtotime($order_complete->created_at)).' '. date('h:i:A', strtotime($order_complete->created_at)) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">You Don't Have Any Order Yet!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- pagination --}}
                            {{ $data['order_complete']->links() }}
                        </div>
                    </div>

                </div>
            </div>


        </div>

    </div>





    @push('script')




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    {{-- <script src="{{ asset('assets/js/notify.min.js') }}" ></script> --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function order_status(id, status){
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                method: "POST",
                url: "{{ url('/order_status') }}",
                data: { id:id, status:status },
                success: function(resp) {
                    $(".order_status_sms").show();
                    $(".order_status_sms").text(resp[1]);
                   setTimeout(() => {
                    location.reload();
                }, 1000);
                }
            });
        }

        $('.show_confirm').click(function(event) {

            var form =  $(this).closest("form");

            var name = $(this).data("name");

            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Want To Cancel This Order!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'

            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Cancelled!',
                        'The order has been cancelled.',
                        'success'
                    )
                    form.submit();
                }
            })

        });
    </script>
    @endpush
@endsection
