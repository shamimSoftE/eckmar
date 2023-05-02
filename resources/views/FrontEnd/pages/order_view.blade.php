@extends('FrontEnd.main')

@section('title', 'Order View')

@push('style')


@endpush

@section('content')

    <div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5">
        <div class="container mt-3">

            @if(isset($data['orders']))

                <ul class="nav nav-pills mb-3 d-inline-flex" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-allOrder-tab" data-bs-toggle="pill" data-bs-target="#pills-allOrder" type="button" role="tab" aria-controls="pills-allOrder" aria-selected="true">All</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-process-tab" data-bs-toggle="pill" data-bs-target="#pills-process" type="button" role="tab" aria-controls="pills-process" aria-selected="false">Processing</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-delivered-tab" data-bs-toggle="pill" data-bs-target="#pills-delivered" type="button" role="tab" aria-controls="pills-delivered" aria-selected="false">Shipped </button>
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

                    <div class="tab-pane fade show active table-responsive" id="pills-allOrder" role="tabpanel" aria-labelledby="pills-allOrder-tab">
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
                                                    <a href="{{ url('/order-process',App\Models\Magician::ed($order->id)) }}" class="text-muted">{{ $order->custom_order_id }}</a>
                                                    @break
                                                @case(1)
                                                    <a href="{{ url('/order-complete',App\Models\Magician::ed($order->id)) }}" class="text-muted">{{ $order->custom_order_id }}</a>
                                                    @break
                                                @case(2)
                                                    <a href="{{ url('/order-shipped',App\Models\Magician::ed($order->id)) }}" class="text-muted">{{ $order->custom_order_id }}</a>
                                                    @break
                                                @case(3)
                                                    <a href="{{ url('/order-dispute',App\Models\Magician::ed($order->id)) }}" class="text-muted">{{ $order->custom_order_id }}</a>
                                                    @break
                                                @default
                                                <form method="POST" action="{{ url('/order_cancel',App\Models\Magician::ed($order->id)) }}">
                                                    @csrf
                                                        &nbsp;<button type="submit" class="btn text-muted text-underline" data-toggle="tooltip" title='Cancel'>
                                                            <u>{{ $order->custom_order_id }}</u>
                                                    </button>
                                                </form>
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
                                                    <span class="badge bg-warning">Dispute</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-danger">Canceled</span>
                                            @endswitch
                                        </td>
                                        <td>@if(isset($product->price)) ${{ number_format($order->product_qty * $product->price) }} @endif</td>
                                        <td>{{ date('dS, M - Y', strtotime($order->created_at)).' '. date('h:i:A', strtotime($order->created_at)) }}</td>
                                        <td>
                                            @switch($order->status)
                                                @case(0)
                                                    <form method="POST" action="{{ url('/order_cancel',App\Models\Magician::ed($order->id)) }}">
                                                        @csrf
                                                         &nbsp;
                                                         <button type="submit" class="btn btn-sm btn-outline-danger show_confirm" data-toggle="tooltip" title='Cancel'>
                                                            <i class="fa-solid fa-times"></i>
                                                        </button>

                                                    </form>
                                                        @break
                                                @case(2)
                                                    <a href="{{ url('order_dispute', App\Models\Magician::ed($order->id)) }}" class="btn text-warning"></a>
                                                    @break
                                                @default
                                            @endswitch
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
                                    <th>Action</th>
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
                                            <a href="{{ url('/order-process',App\Models\Magician::ed($order_pro->id)) }}" class="text-muted">{{ $order_pro->custom_order_id }}</a>
                                        </td>
                                        <td>@if(isset($product->name)) {{ $product->name }} @endif</td>
                                        <td> {{ $order_pro->product_qty }} </td>
                                        <td>@if(isset($vendor->name)) {{ $vendor->name }} @endif</td>
                                        <td><span class="badge bg-primary">Process</span></td>
                                        <td>@if(isset($product->price)) {{ number_format($order_pro->product_qty * $product->price) }} @endif</td>
                                        <td>{{ date('dS, M - Y', strtotime($order_pro->created_at)).' '. date('h:i:A', strtotime($order_pro->created_at)) }}</td>
                                        <td>

                                            <form method="POST" action="{{ url('/order_cancel',App\Models\Magician::ed($order_pro->id)) }}">
                                                @csrf
                                                    &nbsp;<button type="submit" class="btn btn-sm btn-outline-danger show_confirm" data-toggle="tooltip" title='Cancel'>
                                                    <i class="fa-solid fa-times"></i>
                                                </button>

                                            </form>

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
                                            <a href="{{ url('/order-shipped',App\Models\Magician::ed($order_deli->id)) }}" class="text-muted">{{ $order_deli->custom_order_id }}</a>
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
                                            <a href="{{ url('/order-dispute',App\Models\Magician::ed($order_dis->id))  }}" class="text-muted">{{ $order_dis->custom_order_id }}</a>
                                        </td>
                                        <td>@if(isset($product->name)) {{ $product->name }} @endif</td>
                                        <td> {{ $order_dis->product_qty }} </td>
                                        <td>@if(isset($vendor->name)) {{ $vendor->name }} @endif</td>
                                        <td><span class="badge bg-warning">Disputes</span></td>
                                        <td>@if(isset($product->price)) {{ number_format($order_dis->product_qty * $product->price) }} @endif</td>
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
                                            <form method="POST" action="{{ url('/order_cancel',App\Models\Magician::ed($order_cancell->id)) }}">
                                                @csrf
                                                    &nbsp;<button type="submit" class="btn text-muted text-underline" data-toggle="tooltip" title='Cancel'>
                                                        <u>{{ $order->custom_order_id }}</u>
                                                </button>
                                            </form>
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
                                    <th>Action</th>
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
                                            <a href="{{ url('/order-complete',App\Models\Magician::ed($order_complete->id)) }}" class="text-muted">{{ $order_complete->custom_order_id }}</a>
                                        </td>
                                        <td>@if(isset($product->name)) {{ $product->name }} @endif</td>
                                        <td> {{ $order_complete->product_qty }} </td>
                                        <td>@if(isset($vendor->name)) {{ $vendor->name }} @endif</td>
                                        <td><span class="badge bg-secondary">Completed</span></td>
                                        <td>@if(isset($product->price)) ${{ number_format($order_complete->product_qty * $product->price) }} @endif</td>
                                        <td>{{ date('dS, M - Y', strtotime($order_complete->created_at)).' '. date('h:i:A', strtotime($order_complete->created_at)) }}</td>
                                        <td> <a href="{{ url('/order-complete',App\Models\Magician::ed($order_complete->id)) }}" class="text-success"> Leave a feed back </a></td>
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
                @else
                <a href="{{ url()->previous() }}" class="text-center text-secondary list-style-none">Back To Previous Page</a>
            @endif
        </div>
    </div>
@endsection

@push('script')
<script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>
    <script>
        $('.show_confirm').click(function(event) {

            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Want To Cancel This Order.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Cancel it!'

            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Canceled!',
                        'Your file has been Canceled.',
                        'success'
                    )
                    form.submit();
                }
            })
        });
    </script>

@endpush

