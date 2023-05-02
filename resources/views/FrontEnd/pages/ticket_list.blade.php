@extends('FrontEnd.main')

@section('title', 'All-Tickets')

@section('content')

<div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5">
    <!-- left side -->
    <div class="col-lg-3 col-md-2 text-start">
        <div class="shadow rounded">
            <div class="p-3">
                <h3>Support</h3>
            </div>
            <div class="list-group rounded-0 border-0">
                <a href="{{ url('/ticket-list') }}" class="list-group-item"> Tickets </a>

                <a href="#" class="list-group-item"> </a>

                <a href="#" class="list-group-item"> </a>

                <a href="#" class="list-group-item">  </a>
            </div>
        </div>

    </div>

    <!-- right side top part -->
    <div class="col-lg-8 col-md-10 text-start">
        <div class="p-3 user-div shadow rounded">
            <div class="mb-4 text-capitalize inner-content">
                <h3 class="mb-2">All Tickets</h3>
                <div class="mb-3">
                    <button class="btn btn-outline-success">Remove Solved Tickets</button>
                    <button class="btn btn-outline-success">Remove all Tickets</button>
                </div>

                <div class="row mb-4">
                    <div class="col-10"> <input type="text" class="form-control" name="a_day" readonly placeholder="Older then (Days)"></div>
                    <div class="col-2"><button class="btn btn-outline-success">Remove all</button></div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Open by</th>
                            <th scope="col">Time</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $key => $ticket)
                                <tr>
                                    <th scope="row">{{ ++$key }}</th>
                                    <td>{{  $ticket->title  }}</td>
                                    <td>@if(!empty($ticket->user->name)){{ $ticket->user->name }} @endif</td>
                                    <td><small>{{ $ticket->created_at->diffForHumans() }}</small></td>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
