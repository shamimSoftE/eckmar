@extends('FrontEnd.main')

@section('title', 'Aministrators Log')

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

                            <h3 class="pb-3 border-bottom text-start">Activity log of all administrators</h3>

                            {{-- User list --}}
                            <div class="table-responsive mb-5">
                                @if(isset($logs))
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">User</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Performed on</th>
                                                <th scope="col">Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($logs as $key=> $log)
                                                <tr>
                                                    <td>{{ $log->user }}</td>
                                                    <td>{{ $log->type }}</td>

                                                    <td>{{ $log->description }}</td>
                                                    <td>
                                                        @if(isset($log->performed_on->name))
                                                            <span class="badge text-bg-info"> {{ $log->performed_on->name  }} </span>
                                                        @endif
                                                    </td>

                                                    <td class="d-flex">
                                                       {{ date('Y-m-d H:i:s', strtotime($log->created_at)) }}
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5" rowspan="5" class="text-center text-danger"> No Log Found</td>
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
