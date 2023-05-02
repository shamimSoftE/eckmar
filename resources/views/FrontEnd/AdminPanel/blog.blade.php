@extends('FrontEnd.main')

@section('title', 'Blog')

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

                            {{-- <h3 class="pb-3 border-bottom">Message to everyone</h3>
                            <form action="" method="POST" class="mb-5">
                                @csrf

                                <div class="form-group">
                                    <label for="">Message:</label>
                                    <textarea name="message" cols="30" rows="10" class="form-control"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-8 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="admin" name="admin">
                                            <label class="form-check-label" for="admin">
                                              Admins
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="vendor" name="vendor">
                                            <label class="form-check-label" for="vendor">
                                              Vendors
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="buyer" name="buyer">
                                            <label class="form-check-label" for="buyer">
                                              Buyers
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-4 mt-5">
                                        <button type="submit" class="btn btn-sm btn-outline-primary float-end">Send message</button>
                                    </div>
                                </div>
                            </form> --}}

                            {{-- write blog/news --}}
                            <h3 class="pb-3 border-bottom text-start">Blog Add </h3>
                            <form action="{{ url('blog_store') }}" method="POST" class="mb-5">
                                @csrf
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-group text-start mt-1">
                                            <label for="">Write Blog:</label>
                                            <input type="text" name="blog" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group text-start mt-1">
                                            <label for="">Blog For:</label>
                                            <select class="form-select" name="type">
                                                <option value="1">Vendor</option>
                                                <option value="0" selected>Market</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-sm btn-outline-primary float-end mt-2">Save</button>
                            </form>



                            {{-- vendor blog/news list --}}
                            {{-- <button class="btn btn-sm btn-outline-success float-end">Create Blog</button> --}}
                            <h3 class="pb-3 border-bottom text-start">Vendor Blog List</h3>
                            <div class="table-responsive mb-5">
                                @if(isset($newsVendor))
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">News</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($newsVendor as $key=> $v_news)
                                            {{-- {{ dd($v_news) }} --}}
                                                <tr>
                                                    <th scope="row">{{ ++$key }}</th>
                                                    <td>{{ $v_news->header }}</td>
                                                    <td class="d-flex">
                                                        <button type="button" onclick="blogEdit({{ $v_news->id }})" class="btn btn-sm text-primary" title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                                        <form method="POST" action="{{ url('/blog_delete',App\Models\Magician::ed($v_news->id)) }}">
                                                            @csrf
                                                                &nbsp;
                                                                <button type="submit" class="btn btn-sm text-danger show_confirm" data-toggle="tooltip" title='Cancel'>
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- pagination --}}
                                    {{ $newsVendor->links() }}
                                @endif
                            </div>

                            {{-- market blog/news list --}}
                            {{-- <button class="btn btn-sm btn-outline-success float-end">Create Blog</button> --}}
                            <h3 class="pb-3 border-bottom text-start">Market Blog List</h3>
                            <div class="table-responsive">
                                @if(isset($newsMarket))
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">News</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($newsMarket as $key=> $m_news)
                                            {{-- {{ dd($m_news) }} --}}
                                                <tr>
                                                    <th scope="row">{{ ++$key }}</th>
                                                    <td>{{ $m_news->header }}</td>
                                                    <td class="d-flex">
                                                        <button type="button" onclick="blogEdit({{ $m_news->id }})" class="btn btn-sm text-primary" title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                                        <form method="POST" action="{{ url('/blog_delete',App\Models\Magician::ed($m_news->id)) }}">
                                                            @csrf
                                                            &nbsp;
                                                            <button type="submit" class="btn btn-sm text-danger show_confirm" data-toggle="tooltip" title='Delete'>
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- pagination --}}
                                    {{ $newsMarket->links() }}
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>







  <!-- Modal -->
  <div class="modal fade" id="blogUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="blogBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="blogBackdropLabel">Blog Edit</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ url('blog_update') }}" method="POST">
            <div class="modal-body">
                @csrf
                <input type="hidden" name="id">
                <div class="form-group text-start mt-1">
                    <label for="">Write Blog:</label>
                    <input type="text" name="blog" class="form-control">
                </div>

                <div class="form-group text-start mt-1">
                    <label for="">Blog For:</label>
                    <select class="form-select select_data" name="type">
                        <option value="1">Vendor</option>
                        <option value="0">Market</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
      </div>
    </div>
  </div>

@endsection

@push('script')
<script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>
    <script>
        function blogEdit(id)
        {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                method: "POST",
                url: "{{ url('/blog_edit') }}",
                data: {id:id},
                success: function(resp) {
                    $("#blogUpdate [name=id]").val(resp.id);
                    $("#blogUpdate [name=blog]").val(resp.header);
                    $("#blogUpdate .select_data").val(resp.type).trigger("change");
                    $("#blogUpdate").modal('show');
                }
            });
        }

        // blog delete confirm function
        $('.show_confirm').click(function(event) {

            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Want To Delete This Blog.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete it!'

            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        'Your file has been Deleted.',
                        'success'
                    )
                    form.submit();
                }
            })
        });
    </script>

@endpush
