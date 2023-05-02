@extends('FrontEnd.main')

@section('title', 'Mirror Links')

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



                            {{-- write Link--}}
                            <h3 class="pb-3 border-bottom text-start">Mirror Link Add </h3>
                            <form action="{{ url('mirror_link_store') }}" method="POST" class="mb-5">
                                @csrf
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group text-start mt-1">
                                            <label for="">Title:<sup class="text-danger">*</sup></label>
                                            <input type="text" name="title" class="form-control" placeholder="Link Title" required>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group text-start mt-1">
                                            <label for="">Link:<sup class="text-danger">*</sup></label>
                                            <input type="text" name="link" class="form-control" placeholder="Insert Link Here" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-sm btn-outline-primary float-end mt-2">Save</button>
                            </form>



                            {{-- Mirror Link List --}}
                            <h3 class="pb-3 border-bottom text-start">Mirror Link List</h3>
                            <div class="table-responsive mb-5">
                                @if(isset($mirror_links))
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Link</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($mirror_links as $key=> $m_link)
                                            {{-- {{ dd($m_link) }} --}}
                                                <tr>
                                                    <th scope="row">{{ ++$key }}</th>
                                                    <td class="">{{ $m_link->title }}</td>
                                                    <td class="">  {{ $m_link->link }}</td>
                                                    <td class="d-flex">
                                                        <form method="POST" action="{{ url('/mirror_link_delete',App\Models\Magician::ed($m_link->id)) }}" style=" margin-top: -23px; ">
                                                            @csrf
                                                                &nbsp;
                                                                <button type="submit" class="btn btn-sm text-danger show_confirm" data-toggle="tooltip" title='Delete'>
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                        <button type="button" onclick="blogEdit({{ $m_link->id }})" class="btn btn-sm text-primary " title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    {{-- pagination --}}
                                    {{ $mirror_links->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>







  <!-- Modal -->
  <div class="modal fade" id="mirrorLinkUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mLinkBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="mLinkBackdropLabel">Mirror Link Edit</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ url('mirror_link_update') }}" method="POST">
            <div class="modal-body">
                @csrf
                <input type="hidden" name="id">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group text-start mt-1">
                            <label for="">Title:</label>
                            <input type="text" name="title" class="form-control" placeholder="Link Title">
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group text-start mt-1">
                            <label for="">Link:<sup class="text-danger">*</sup></label>
                            <input type="text" name="link" class="form-control" placeholder="Insert Link Here" required>
                        </div>
                    </div>
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
                url: "{{ url('/mirror_link_edit') }}",
                data: {id:id},
                success: function(resp) {
                    $("#mirrorLinkUpdate [name=id]").val(resp.id);
                    $("#mirrorLinkUpdate [name=link]").val(resp.link);
                    $("#mirrorLinkUpdate [name=title]").val(resp.title);
                    $("#mirrorLinkUpdate").modal('show');
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
                text: "Want To Delete This Link.",
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
