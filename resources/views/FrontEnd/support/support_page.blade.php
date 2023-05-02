@extends('FrontEnd.main')

@section('title', 'Support Panel')

@push('style')
    <style>
        .dispute_field{ display: none;}
    </style>
@endpush

@section('content')

    @if(auth()->user()->type == 2 || auth()->user()->type == 3)

        <div class="row justify-content-between mt-5 mb-3 mx-0 px-5">
            <div class="col-lg-2 col-md-2">
                <div class="shadow rounded pl-1">
                    <div class="list-group rounded-0 border-0">
                        <a href="{{ url('support-panel') }}" class="list-group-item fw-bold @if(request()->segment(1) == 'support-panel') c_active @endif" style="padding: 12px"> Disputes </a>
                        <a href="{{ url('support-ticket') }}" class="list-group-item fw-bold @if(request()->segment(1) == 'support-ticket') c_active @endif" style="padding: 12px"> Tickets </a>

                        @if (auth()->user()->type == 3)


                            <a href="{{ url('admin-panel') }}" class="list-group-item fw-bold" title="Back To Dashboard" style="padding: 12px">
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>


                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-10 col-md-10">

                <div class="p-3 shadow rounded news text-start">
                    <div class="container mt-3">

                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-sm-8" style=" border-right: 4px solid #80808040; ">
                                <h3 class="text-start">All Disputes</h3>
                                <div class="table-responsive">
                                    <table class="table table-border table-hover mt-3" style="height: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Purchase</th>
                                                <th>Buyer</th>
                                                <th>Vendor</th>
                                                <th>Total</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody style="width: 100%; max-height: 251px; overflow-y: scroll; padding: 5px;">
                                            @foreach ($disputes as $dis)
                                                @php
                                                    if(isset($dis->customer_id))
                                                    {
                                                        $user_name = App\Models\User::find($dis->customer_id)->name;
                                                    }
                                                    $order = App\Models\Order::find($dis->order_id);
                                                    $pro_price = App\Models\Product::find($order->product_id)->price;
                                                    $vendor_name = App\Models\User::find($order->seller_id)->name;
                                                @endphp
                                                <tr>
                                                    <td><a href="javascript:void(0)" onclick="get_dispute_sms({{ $dis->order_id }})" class="text-muted">{{ @$order->custom_order_id }}</a></td>
                                                    <td>{{ @$user_name }}</td>
                                                    <td>{{ @$vendor_name }}</td>
                                                    <td>${{ @$order->product_qty* @$pro_price  }}</td>
                                                    <td>{{ $dis->created_at->diffForHumans() }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-4">
                                <h3 class="text-start dispute_field">Disputes Message</h3>
                                <div class="dispute_field">

                                    <div class="dispute_sms_get" style="width: 100%; max-height: 251px; overflow-y: scroll; padding: 20px;">
                                        {{-- dispute message --}}
                                    </div>

                                    <form method="post" class="dispute_form" style="margin-top: 10px;">
                                        @csrf
                                        <textarea class="form-control" placeholder="Type here to start the dispute" name="message" rows="2"></textarea>
                                        <input type="hidden" name="order_id" value="">
                                        <input type="hidden" name="support_id" value="{{ Auth::user()->id }}">
                                        <button type="submit" class="btn btn-sm btn-outline-success mt-1 float-right">Send New Message</button>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>


            </div>
        </div>
    @endif


@endsection

@push('script')

  <script>
    $(document).ready(function(){


    //   setInterval(() => {
    //     get_disputes(order_id);
    //   }, 5000);
    });

    $(".dispute_form").on('submit', function(e) {
      e.preventDefault();

      $.ajaxSetup({  headers: {  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }  });

      $.ajax({
          type: 'POST',
          url: '/send_dispute_sms',
          data: $(".dispute_form").serialize(),
          success: function(response) {
            $(".dispute_form").trigger("reset");

            // get order id
            let order_id = $(".dispute_form [name=order_id]").val();
            get_dispute_sms(order_id)
          }
      });
    });

    function get_dispute_sms(id) {

        $(".dispute_form [name=order_id]").val(id);
        $.ajaxSetup({  headers: {  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }  });
        $.ajax({
            type: "post",
            url: "{{ url('/get_dispute_message') }}",
            data:{id: id},
            success: function(res) {
                $(".dispute_field").show();
                $(".dispute_sms_get").html(res);

            }
        });
    }
  </script>

@endpush
