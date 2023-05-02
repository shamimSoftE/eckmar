@extends('FrontEnd.main')

@section('title', 'Admin-Panel')

@push('style')
<style>
    .c_active{ color: #ffffff; background-color: #198754; }
    .c_text{font-size: 12px!important; text-decoration: none!important; }
    .cc_body {min-height: 115px!important; }
    table, td { font-size: 12px; }
</style>
@endpush

@section('content')

    <div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5">
        <!-- left side -->
        <div class="col-xl-3 col-xxl-3 col-lg-3 col-md-2 text-start">
            <div class="shadow rounded">
                <div class="text-center py-2 rounded-top @if(request()->segment(1) == 'admin-panel') c_active @endif">
                    <a href="{{ url('/admin-panel') }}" class="text-decoration-none text-white text-dark ">Market Statistics</a>
                </div>
                @include('FrontEnd.AdminPanel.include.sidebar')

            </div>

        </div>

        <!-- right side top part -->
        <div class="col-xl-8 col-xxl-8 col-lg-8 col-md-10 text-start">
            <div class="p-3 user-div shadow rounded">
                <div class="mb-4 inner-content">
                    <div class="row">


                        <div class="col-12">
                            <h3 class="text-center pb-3">Market Statistics</h3>
                        </div>

                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
                            <div class="card text-center">
                                <div class="card-body cc_body">
                                  <h5 class="card-title">
                                    @if(isset($data['total_product']))
                                        {{ $data['total_product'] }}
                                    @endif
                                  </h5>
                                  <a href="#" class="c_text fw-bold text-muted">Number Of Products In Market.</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
                            <div class="card text-center">
                                <div class="card-body cc_body">
                                  <h5 class="card-title">
                                    @if(isset($data['total_vendor']))
                                        {{ $data['total_vendor'] }}
                                    @endif
                                  </h5>
                                  <a href="#" class="c_text fw-bold text-muted">Number Of Vendor On This Market.</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
                            <div class="card text-center">
                                <div class="card-body cc_body">
                                  <h5 class="card-title">
                                    @if(isset($data['total_user_register']))
                                        {{ $data['total_user_register'] }}
                                    @endif
                                  </h5>
                                  <a href="#" class="c_text fw-bold text-muted">Number Of Users Registered In Market.</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
                            <div class="card text-center">
                                <div class="card-body cc_body">
                                  <h5 class="card-title">
                                    @if(isset($data['total_support']))
                                        {{ $data['total_support'] }}
                                    @endif
                                  </h5>
                                  <a href="#" class="c_text fw-bold text-muted">Number Of Supports.</a>
                                </div>
                            </div>
                        </div>


                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 mt mt-3">
                            <div class="card text-center">
                                <div class="card-body cc_body">
                                  <h5 class="card-title">
                                    @if(isset($data['total_dispute_order']))
                                        {{ $data['total_dispute_order'] }}
                                    @endif
                                  </h5>
                                  <a href="#" class="c_text fw-bold text-muted">Total Number Of Dispute Pending.</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 mt-3">
                            <div class="card text-center">
                                <div class="card-body cc_body">
                                  <h5 class="card-title">
                                    @if(isset($data['total_pending_order']))
                                        {{ $data['total_pending_order'] }}
                                    @endif
                                  </h5>
                                  <a href="#" class="c_text fw-bold text-muted">Total Number Of Order Pending.</a>

                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 mt-3">
                            <div class="card text-center">
                                <div class="card-body cc_body">
                                  <h5 class="card-title">
                                    @if(isset($data['total_cancel_order']))
                                        {{ $data['total_cancel_order'] }}
                                    @endif
                                  </h5>
                                  <a href="#" class="c_text fw-bold text-muted">Total Number Of Order Cancel.</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 mt-3">
                            <div class="card text-center">
                                <div class="card-body cc_body">
                                  <h5 class="card-title">
                                    @if(isset($data['total_order']))
                                        {{ $data['total_order'] }}
                                    @endif
                                  </h5>
                                  <a href="#" class="c_text fw-bold text-muted">Total Number Of Order Overall</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 mt-3">
                            <div class="card text-center">
                                <div class="card-body cc_body">
                                  <h5 class="card-title">
                                    @if(isset($data['purchase_last_24h']))
                                        {{ $data['purchase_last_24h'] }}
                                    @endif
                                  </h5>
                                  <a href="#" class="c_text fw-bold text-muted">Number Of Purchases In Last 24h.</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 mt-3">
                            <div class="card text-center">
                                <div class="card-body cc_body">
                                  <h5 class="card-title">
                                    @if(isset($data['purchase_last_week']))
                                        {{ $data['purchase_last_week'] }}
                                    @endif
                                  </h5>
                                  <a href="#" class="c_text fw-bold text-muted">Number Of Purchases In Last Week.</a>

                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 mt-3">
                            <div class="card text-center">
                                <div class="card-body cc_body">
                                  <h5 class="card-title">
                                    @if(isset($data['purchase_last_month']))
                                        {{ $data['purchase_last_month'] }}
                                    @endif
                                  </h5>
                                  <a href="#" class="c_text fw-bold text-muted">Number Of Purchases In Last Month</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 mt-3">
                            <div class="card text-center">
                                <div class="card-body cc_body">
                                    <h5 class="card-title">
                                        @if(isset($data['total_completed_order']))
                                            {{ $data['total_completed_order'] }}
                                        @endif
                                    </h5>
                                    <a href="#" class="c_text fw-bold text-muted">Total Number Of Order Completed</a>
                                </div>
                            </div>
                        </div>



                        {{-- <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="text-center fw-bold">Top Vendor</h6>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                              <tr>
                                                <th scope="col">#</th>
                                                <td>Name</td>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <tr>
                                                <th scope="row">1</th>
                                                <td>John</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">2</th>
                                                <td>Oliver</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">3</th>
                                                <td>Abraham</td>
                                              </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="text-center fw-bold">Top Category</h6>
                                    <div class="table-responsive" style="max-height: 209px;">
                                        <table class="table">
                                            <thead>
                                              <tr>
                                                <th scope="col">#</th>
                                                <td>Name</td>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($data['top_category']))
                                                    @foreach ($data['top_category'] as $key=> $cate)
                                                        <tr>
                                                            <th scope="row">{{ ++$key }}</th>
                                                            <td>{{ $cate->name }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div><div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="text-center fw-bold">Top Product</h6>
                                    <div class="table-responsive" style="max-height: 209px;">
                                        <table class="table">
                                            <thead>
                                              <tr>
                                                <th scope="col">#</th>
                                                <td>Name</td>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($data['top_product']))
                                                    @foreach ($data['top_product'] as $key=> $pro)
                                                        <tr>
                                                            <th scope="row">{{ ++$key }}</th>
                                                            <td>{{ $pro->name }}</td>
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
                </div>
            </div>

        </div>
    </div>
@endsection
