@extends('FrontEnd.main')

@section('title', 'All-Notification')

@section('content')

<div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5">

    <div class="col-lg-12 col-md-12 text-start">
        <div class="p-3 user-div shadow rounded">
            <div class="mb-4 text-capitalize inner-content">
                <h3 class="mb-2">All Notification</h3>
                <div class="mb-3">
                    <button class="btn btn-outline-success btn-sm">Delete All Notification</button>
                </div>


                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            {{-- <th scope="col">#</th> --}}
                            <th scope="col">Notifications</th>
                            <th scope="col">Time</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($notification as $key => $noti) --}}
                                {{-- <tr>
                                    <th scope="row">{{ ++$key }}</th>
                                    <td>{{  $$noti->title  }}</td>
                                    <td>@if(!empty($$noti->user->name)){{ $$noti->user->name }} @endif</td>
                                    <td><small>{{ $$noti->created_at->diffForHumans() }}</small></td>
                                </tr> --}}
                                <tr>
                                    {{-- <th scope="row">{{ ++$key }}</th> --}}
                                    <td>{{  __('Item Shipped')  }}</td>
                                    <td><small>{{ __('11 hrs  ago') }}</small></td>
                                    <td> <a href="javascript:void(0)" class="btn btn-outline-dark btn-sm">View</a> </td>
                                </tr>
                            {{-- @endforeach --}}
                        </tbody>
                      </table>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
