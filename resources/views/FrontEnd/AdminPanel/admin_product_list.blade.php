@extends('FrontEnd.main')

@section('title', 'Product List')

@push('style')
<style>
    .c_active{ color: #ffffff; background-color: #198754; }
    .c_text{font-size: 12px!important; text-decoration: none!important; }
</style>
@endpush

@section('content')

    <div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5">
        <!-- left side -->
        <div class="col-xl-3 col-xxl-3 col-lg-3 col-md-2 text-start">
            <div class="shadow rounded">
                <div class="text-center py-2 rounded-top @if(request()->segment(1) == 'admin-panel') c_active @endif">
                    <a href="{{ url('/admin-panel') }}" class="text-decoration-none text-dark ">Market Statistics</a>
                </div>
                @include('FrontEnd.AdminPanel.include.sidebar')
            </div>
        </div>

        <!-- right side top part -->
        <div class="col-xl-8 col-xxl-8 col-lg-8 col-md-10 text-start">
            <div class="p-3 user-div shadow rounded">
                <div class="mb-4 inner-content">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">

                            <h3 class="pb-3 border-bottom text-start">List Of Products</h3>
                            {{-- <form action="{{ url('admin_product_filter') }}" method="POST" class="mb-3"> --}}
                            <form method="POST" action="{{ route('adminProFilter') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group text-start mt-1">
                                            <label for="">Product Name:</label>
                                           <input type="text" name="product_name" placeholder="product name"
                                           value="@if(isset($input['product_name'])) {{ $input['product_name'] }} @endif"
                                           class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group text-start mt-1">
                                            <label for="">Vendor Name:</label>
                                           <input type="text" name="vendor_name" placeholder="vendor name"
                                           value="@if(isset($input['vendor_name'])) {{ $input['vendor_name'] }} @endif"
                                           class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="form-group text-start mt-1">
                                            <label for="">Order by:</label>
                                            <select class="form-select" name="order_by">
                                                <option value="1"
                                                    @if(isset($input['order_by']))
                                                        @if($input['order_by'] == 1) selected @endif
                                                    @endif>
                                                    Newest
                                                </option>
                                                <option value="0"
                                                    @if(isset($input['order_by']))
                                                        @if($input['order_by'] == 0) selected @endif
                                                    @endif>
                                                    Oldest
                                                </option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-2">
                                        <div class="form-group text-start mt-4">
                                            <button type="submit" class="btn btn-sm btn-primary float-end">Apply filter</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
<hr>


                            {{-- User list --}}
                            <div class="table-responsive mb-5">
                                @if(isset($products))
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                {{-- <th scope="col">#</th> --}}
                                                <th scope="col">Title</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Vendor</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($products as $key=> $pro)
                                                <tr>
                                                    {{-- <th scope="row">{{ ++$key }}</th> --}}
                                                    <td>{{ $pro->name }}</td>
                                                    <td>
                                                        @if(isset($pro->category->name))
                                                        <span class="badge text-bg-primary"> {{ $pro->category->name  }}</span>
                                                        @endif
                                                    </td>
                                                    <td>$ {{ number_format($pro->price) }}</td>
                                                    <td>
                                                        @if(isset($pro->category->name))
                                                            <span class="badge text-bg-info"> {{ $pro->seller->name  }} </span>
                                                        @endif
                                                    </td>

                                                    <td class="d-flex">
                                                        <a href="{{ url('admin_product_edit',App\Models\Magician::ed($pro->id)) }}" class="btn btn-sm btn-primary text-white">
                                                        <i class="fa-solid fa-pencil"></i> </a>

                                                        {{-- <a href="" class="btn btn-sm btn-danger text-white">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a> --}}

                                                        <form method="POST" action="{{ url('/admin_product_delete',App\Models\Magician::ed($pro->id)) }}">
                                                            @csrf
                                                                &nbsp;
                                                                <button type="submit" class="btn btn-sm btn-danger text-white show_confirm" data-toggle="tooltip" title='Delete'>
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>

                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5" rowspan="5" class="text-center text-danger"> No Product Found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
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
                text: "Want To Delete This Product.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete it!'

            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        'Product has been Deleted.',
                        'success'
                    )
                    form.submit();
                }
            })
});
    </script>

@endpush
