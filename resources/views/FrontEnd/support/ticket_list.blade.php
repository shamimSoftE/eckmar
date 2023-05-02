@extends('FrontEnd.main')

@section('title', 'Open-Ticket')

@push('style')

<style>
    .close_ticket{
        display: none !important
    }

    .text-small {
        font-size: 0.9rem;
    }

    .small {
        font-size: .7rem;
    }

    .messages-box,
    .chat-box {
        height: 510px;
        overflow-y: scroll;
    }

    .message-input::-webkit-scrollbar,
    .messages-box::-webkit-scrollbar,
    #message_box::-webkit-scrollbar {
        display: none;
    }

    .message-input,
    .messages-box,
    #message_box {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .list-group-item {
        border: 0;
        border-bottom: 1px solid rgba(0, 0, 0, .125);
    }

    input::placeholder {
        font-size: 0.9rem;
        color: #999;
    }

    .ml-auto,
    .mx-auto {
        margin-left: auto !important;
    }

    .close-btn {
        position: absolute;
        right: 10px;
        top: 10px;
        font-size: 20px;
        font-weight: bold;
        color: #000;
        cursor: pointer;
    }

    [type=button]:focus,
    [type=button]:hover,
    [type=submit]:focus,
    [type=submit]:hover,
    button:focus,
    button:hover {
        color: #fff;
        background-color: transparent;
        text-decoration: none
    }
    .active_ticket {
        background-color: #72b5897a!important;
    }

    .create-ticket {
        background-color: #198754;
        padding: 6px 13px;
        text-transform: uppercase;
        font: normal normal 13px/1em 'Assistant', sans-serif;
    }
    .create-ticket:hover {
        background-color: #efab67;
    }
    .close-ticket {
        background-color: #efab67;
        padding: 6px 13px;
        text-transform: uppercase;
        font: normal normal 13px/1em 'Assistant', sans-serif;
    }
    .close-ticket:hover {
        background-color: #198754;
    }
    .btn:focus {
        box-shadow: none !important;
    }
    .open {
        background-color: #198754;
    }

    /* css for review */
    .active-review span {
        pointer-events: none;
    }
    .active-review a {
        pointer-events: none;
    }
    .review-section {
        display: none;
        z-index: 999;
    }
    .review {
        float: left;
        height: 46px;
        padding: 0 10px;
    }
    .review input {
        display: none;
    }
    .review:not(:checked) > input {
        position:absolute;
    }
    .review:not(:checked) > label {
        float:right;
        width:1em;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px;
        color:#ccc;
    }
    .review:not(:checked) > label:before {
        content: '★ ';
    }
    .review > input:checked ~ label {
        color: #f58020 ;
    }
    .review:not(:checked) > label:hover,
    .review:not(:checked) > label:hover ~ label {
        color: #f58020 ;
    }
    .review > input:checked + label:hover,
    .review > input:checked + label:hover ~ label,
    .review > input:checked ~ label:hover,
    .review > input:checked  label:hover  label,
    .review > label:hover  input:checked  label {
        color: #f58020 ;
    }
    a{
        text-decoration: none;
    }
</style>

@endpush

@section('content')

@if(auth()->user()->type == 2 || auth()->user()->type == 3)

    <div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5">
        <!-- left side -->
        <div class="col-lg-2 col-md-1">
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
        <!-- left side -->

            <div class="col-lg-8 col-md-10 text-start">
                <div class="support_ticket">
                    <div class="row rounded-lg overflow-hidden shadow support_icket mx-1">

                        <div class="col-md-5 ps-0 pe-0 pe-md-1 ">
                            <div class="bg-white h-100">
                                <div class="bg-gray ps-3 pe-3 pe-md-2 py-2 bg-light d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Ticket</h5>
                                </div>
                                <div style=" border-right: 10px solid #f8f9fa;" class="messages-box">
                                    <div class="list-group rounded-0" id="ticket_lticket_ist">
                                        @foreach ($data['tickets'] as $key => $ticket)
                                            @php
                                                $ticket = $ticket[0];
                                            @endphp

                                            <a onclick="get_message({{ $ticket->ticket_id }})" class="position-relative list-group-item list-group-item-action active_ticket_{{$ticket->ticket_id}} ticket_list {{ $key == 0 ? 'active_ticket' : '' }}" style="cursor: pointer;" id="ticket_{{ $ticket->id }}">
                                                <div class="media d-flex align-item-center">
                                                    <div class="media-body w-100">
                                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                                            <h6 class="mb-0 d-flex align-items-center">
                                                                @if ($ticket->status == 1)
                                                                    <i class="fas fa-circle text-success me-2" style="font-size: 9px" aria-hidden="true"></i>
                                                                @else
                                                                    <i class="fas fa-circle text-danger me-2"  style="font-size: 9px" aria-hidden="true"></i>
                                                                @endif

                                                                @if(isset($ticket->category->name))
                                                                    {{ $ticket->category->name }}
                                                                @else
                                                                    @php
                                                                        $cate_name = App\Models\TicketCategory::find($ticket->cat_id)->name;
                                                                    @endphp
                                                                    {{ @$cate_name }}
                                                                @endif
                                                            </h6>
                                                            <p class="small font-weight-bold"> {{ date('d M', strtotime($ticket->created_at)) }}</p>
                                                        </div>
                                                        <p class="font-italic   mb-0 text-small"> Ticket ID:  {{ $ticket->ticket_id }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7 ps-0 ps-md-1 pe-0 position-relative">
                            <div class="bg-gray ps-3 pe-3 pe-md-2 py-2 bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Ticket ID: <span class="ticket_title"></span></h5>
                                <a title="Close ticket" class="close-ticket text-white close_ticket d-flex align-items-center review-ticket ticket_close_btn" onclick="close_ticket()" role="button" style="display: none;">
                                    <span class="fs-5 fw-bold">×</span>&nbsp;  Close
                                </a>
                            </div>
                            <div class="px-4 py-5 chat-box bg-white" id="message_box">
                                <!-- Sender & Receiver Message-->
                            </div>

                            <form class="bg-light message_form" action="javascript:void(0);">
                                <input type="hidden" value="" name="ticket_id" id="ticket_id">
                                <div class="input-group d-flex align-items-center">
                                    <textarea name="message" id="" class="form-control message-input message"></textarea>
                                    <div class="input-group-append">
                                        <button id="button-addon2" type="submit" class="btn btn-link">
                                        <i class="fa fa-paper-plane" style="color: #49c3cb"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    @endif

@endsection





@push('script')


<script>
    var ticket_id = 0;

    setInterval(function() {
        get_message(ticket_id);
        unread_message_count();
        if(ticket_id){
            reload_ticket();
        }
    }, 5000);



    function get_message(id) {
        $('.ticket_list').removeClass('active_ticket');
        $('.active_ticket_'+id).addClass('active_ticket');
        $(".message_form [name=ticket_id]").val(id);

        start_interval = 1;
        ticket_id = id;

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

        $.ajax({
            type: "GET",
            url: "{{ url('admin/ticket/get_message') }}/" + id,
            success: function(data) {
                $('.ticket_id_input').val(id);
                if (data[0] == "success") {
                    $("#message_box").html(data[1]);
                    $('.user_name').html('#'+id+' | '+data[2].user.name)
                    $('.user_image').html(data[3]);

                    if(data[2].status==2){
                        $('.ticket_close_btn').hide();
                        $('.chat-app-form').hide();
                        $('.chat-app-window .user-chats').css('height','calc(100% - 65px)')
                    }else{
                        $('.ticket_close_btn').show();
                        $('.chat-app-form').show();
                        $('.chat-app-window .user-chats').css('height','calc(100% - 65px - 65px)')
                    }
                }
            }
        });

    }

    $(".message_form").on('submit', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '/ticket/reply/message',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                if (response[0] == 'error') {
                    console.log(response[1]);
                } else {
                    $(".message_form").trigger("reset");
                    get_message(ticket_id);
                    reload_ticket();
                }
            }
        });
    });


    function close_ticket() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: "{{ url('/ticket/close') }}/" + ticket_id,
            success: function(data) {
                setTimeout(function() {
                    location.reload();
                }, 200);
                msg('success', response[1]);
            }
        });
    }

    function unread_message_count(){
        $.ajax({
            type: "GET",
            url: "{{ url('admin/ticket/unread') }}",
            success: function(data) {
                if (data[0] == "success") {
                    data[1].forEach(element => {
                        if(element.unread>0){
                            $('.unread_message_'+element.ticket_id).text(element.unread);
                        }
                   });
                }
            }
        });
    }

    function reload_ticket(){
        $.ajax({
            type: "GET",
            url: "{{ url('admin/ticket/reload_ticket') }}",
            success: function(data) {
                if (data[0] == "success") {
                    $('.tickets').html(data[1]);
                    $('.active_ticket_'+ticket_id).addClass('active_ticket');
                }
            }
        });
    }

    $(document).on('click','.message_image',function(){
        $('#show_image').modal('show');
        $('#preview_message_image').attr('src',$(this).attr('src'));
    });


</script>

@endpush
