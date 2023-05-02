@extends('FrontEnd.main')

@section('title', 'Product List')

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
                    {{-- <h3 class="border-none">Product List</h3> --}}
                    <span class="text-center fw-bold border-bottom" style="font-size:25px">Product List</span>
                    <div class="text-start table-responsive">
                        <table class="table table-border table-hover" style="height: 100%;">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $pro)
                                    <tr>
                                        <td>
                                            <a href="{{ url('/product_edit',App\Models\Magician::ed($pro->id)) }}" class="d-flex text-decoration-none text-muted">
                                               @if(!empty($pro->image)) <img src="{{ asset('assets/images/product/'.$pro->image) }}" class="rounded float-start" style="max-width: 75px"  alt="product image">@endif
                                                <span class="p-2">{{ $pro->name }}</span>
                                            </a>
                                        </td>
                                        <td>@if(!empty($pro->category->name)) <span class="text-success"> {{ $pro->category->name }} </span> @endif</td>
                                        <td>{{ $pro->qty }}</td>
                                        <td>${{ $pro->price }}</td>
                                        <td >
                                            <div class="d-flex">
                                                <a href="{{ url('/autofill_add',App\Models\Magician::ed($pro->id)) }}" class="text-decoration-none btn btn-sm btn-outline-info" title="Add Autofill">
                                                    <i class="fa-solid fa-plus-circle"></i>
                                                </a>
                                                &nbsp;
                                                <a href="{{ url('/product_edit',App\Models\Magician::ed($pro->id)) }}" class="text-decoration-none btn btn-sm btn-outline-success" title="Edit">
                                                    <i class="fa-solid fa-pencil"></i>
                                                </a>

                                                {{-- <a href="{{ url('/product_delete',App\Models\Magician::ed($pro->id)) }}"
                                                    class="text-decoration-none btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a> --}}

                                                <form method="POST" action="{{ url('/product_delete',App\Models\Magician::ed($pro->id)) }}">
                                                    @csrf

                                                     &nbsp;<button type="submit" class="btn btn-sm btn-outline-danger show_confirm" data-toggle="tooltip" title='Delete'>
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>

                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>

                        {{-- pagination --}}
                        {{ $products->links() }}
                        {{-- <nav aria-label="Page navigation example" style="float: right">
                            <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            </ul>
                        </nav> --}}
                    </div>

                </div>
            </div>


        </div>

    </div>





    @push('script')

    {{-- <script src="{{ asset('assets/js/notify.min.js') }}" ></script> --}}
    <script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>

    <script>

        $('.show_confirm').click(function(event) {

            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Want To Delete This. It would not be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'

            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                    form.submit();
                }
            })
        });
    </script>
    @endpush
@endsection
