@extends('FrontEnd.main')

@section('title', 'User List')

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

                            <h3 class="pb-3 border-bottom text-start">List Of Users</h3>
                            <form action="{{ url('user_filter') }}" method="POST" class="mb-3">
                                @csrf
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group text-start mt-1">
                                            <label for="">Username:</label>
                                           <input type="text" name="username" placeholder="Username of the user"
                                           value="@if(isset($input['username'])) {{ $input['username'] }} @endif"
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

                                    <div class="col-3">
                                        <div class="form-group text-start mt-1">
                                            <label for="">Display Only:</label>
                                            <select class="form-select" name="type">
                                                <option value="5"
                                                    @if(isset($input['type']))
                                                        @if($input['type'] == 5) selected @endif
                                                    @endif>
                                                    Everyone
                                                </option>
                                                <option value="0"
                                                    @if(isset($input['type']))
                                                        @if($input['type'] == 0) selected @endif
                                                    @endif>
                                                    User
                                                </option>
                                                <option value="1"
                                                    @if(isset($input['type']))
                                                        @if($input['type'] == 1) selected @endif
                                                    @endif>
                                                    Vendor
                                                </option>
                                                <option value="2"
                                                    @if(isset($input['type']))
                                                        @if($input['type'] == 2) selected @endif
                                                    @endif>
                                                    Administrative
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
                            <div class="table-responsive" style="max-height: 449px;">
                                @if(isset($users))
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                {{-- <th scope="col">#</th> --}}
                                                <th scope="col">Username</th>
                                                <th scope="col">Group</th>
                                                <th scope="col">Last Login</th>
                                                <th scope="col">Registration Date</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $key=> $user)
                                                <tr>
                                                    {{-- <th scope="row">{{ ++$key }}</th> --}}
                                                    <td>{{ $user->name }}</td>
                                                    <td>
                                                        @switch($user->type)
                                                            @case(0)
                                                                {{ __('User')  }}
                                                                @break
                                                            @case(1)
                                                                <span class="badge text-bg-primary"> {{ __('Vendor')  }}</span>
                                                                @break
                                                            @case(2)
                                                            <span class="badge text-bg-warning"> {{ __('Administrator')  }} </span>
                                                                @break

                                                            @default

                                                        @endswitch
                                                    </td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($user->last_login)->diffForHumans() }}
                                                    </td>
                                                    <td>{{ date('Y-m-d H:m:s', strtotime($user->created_at)) }}</td>

                                                    <td><a href="{{ url('user_details',App\Models\Magician::ed($user->id)) }}" class="btn btn-sm btn-secondary text-white"><i class="fa-solid fa-search-plus"></i>View </a> </td>
                                                </tr>
                                            @endforeach
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

@endpush
