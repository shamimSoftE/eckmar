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
        background-color: var(--wp--light--green);
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
<div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5">
    <!-- left side -->

        <div class="col-lg-2 col-md-1"></div>
        <div class="col-lg-8 col-md-10 text-start">
            <div class="support_ticket">
                <div class="row rounded-lg overflow-hidden shadow support_icket mx-1">

                    <div class="col-md-5 ps-0 pe-0 pe-md-1 ">
                        <div class="bg-white h-100">
                            <div class="bg-gray ps-3 pe-3 pe-md-2 py-2 bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Ticket</h5>

                                @if (isset($active_ticket))
                                    <a onclick="ticketFindMessage()" class="create-ticket text-white d-flex align-items-center" role="button">
                                        <i class="fa fa-plus" aria-hidden="true" style="font-size: 10px;color:white"></i>&nbsp; Create
                                    </a>
                                @else
                                    <a title="Create New Tickets" onclick="createTicketModal()" class="create-ticket text-white d-flex align-items-center" role="button">
                                        <i class="fa fa-plus" aria-hidden="true" style="font-size: 10px;color:white"></i>&nbsp; Create
                                    </a>
                                @endif
                            </div>
                            <div style=" border-right: 10px solid #f8f9fa;" class="messages-box">
                                <div class="list-group rounded-0" id="ticket_lticket_ist">
                                    @foreach ($tickets as $key => $ticket)
                                        @if ($key == 0)
                                            <script>
                                                var ticket_id = {{ $ticket->id }}
                                            </script>
                                        @endif

                                        <a onclick="get_ticket({{ $ticket->id }})" class="position-relative list-group-item list-group-item-action {{ $key == 0 ? 'active_ticket' : '' }}" style="cursor: pointer;" id="ticket_{{ $ticket->id }}">
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
                                                            @endif
                                                        </h6>
                                                        <p class="small font-weight-bold"> {{ date('d M', strtotime($ticket->created_at)) }}</p>
                                                    </div>
                                                    <p class="font-italic   mb-0 text-small"> Ticket ID:  {{ $ticket->id }}</p>
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
                            <a title="Close ticket" class="close-ticket text-white close_ticket d-flex align-items-center review-ticket" role="button" style="display: none;">
                                <span class="fs-5 fw-bold">×</span>&nbsp;  Close
                            </a>
                        </div>
                        <div class="px-4 py-5 chat-box bg-white" id="message_box">
                            <!-- Sender & Receiver Message-->
                        </div>

                        <form class="bg-light message_form" enctype="multipart/form-data">
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

                    {{-- rating form --}}
                    <div class="position-absolute bottom-0 w-100 bg-light review-section">
                        <form action="{{ url('/ticket/close') }}" class="px-2 py-4" method="post">
                            @csrf
                            <input type="hidden" name="id" class="ticket_id" value="3">
                            <textarea name="review_message" class="form-control" style="box-shadow: none !important; background: #FFFFFF !important" cols="4" rows="2"></textarea>
                            <div>
                                <label for="" class="text-start">Give Rating</label>
                            </div>
                            <div class="review mt-1 d-block">
                                <input type="radio" id="star5" name="review_star" value="5" required="">
                                <label for="star5" title="5">5 stars</label>
                                <input type="radio" id="star4" name="review_star" value="4">
                                <label for="star4" title="4">4 stars</label>
                                <input type="radio" id="star3" name="review_star" value="3">
                                <label for="star3" title="3">3 stars</label>
                                <input type="radio" id="star2" name="review_star" value="2">
                                <label for="star2" title="2">2 stars</label>
                                <input type="radio" id="star1" name="review_star" value="1">
                                <label for="star1" title="1">1 star</label>
                            </div>
                            <div class="mt-5 text-end">
                                <button type="submit" class="aihcon-secondary-button" style="padding: 10px 25px !important;">Submit</button>
                            </div>
                        </form>
                    </div>
                    {{-- rating form --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-1"></div>
</div>


{{-- create ticket modal --}}
<div class="modal fade" id="create_ticket_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="create_ticketLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="create_ticketLabel">Create Ticket</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="create_ticket_form" autocomplete="off" method="" enctype="multipart/form-data">
            <div class="modal-body">

                <div class="mb-3">
                    <label for="" class="pull-left mb-2"><small>Ticket Category</small></label>
                    <select name="cat_id" class="form-control" id="ticket_category">
                        @foreach ($categorys as $cate)
                            <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="" class="pull-left mb-2"><small>Message</small></label>
                    <textarea class="form-control w-100" name="message" placeholder="Your Message?" rows="4"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="blue-shadow-button bg-success" style="border: none;color:white; padding: .5em 1.2em !important;">Create</button>
            </div>
        </form>
      </div>
    </div>
  </div>
{{-- create ticket modal --}}

@endsection








@push('script')


{{-- <script type="text/javascript">
    function msg(type, text) {
        if (type == 'success') {
            Toastify({
                text: text,
                duration: 1500,
                close: false,
                gravity: "top",
                backgroundColor: "linear-gradient(to right, #4caf50, #4caf50)",
            }).showToast();
        }

        if (type == 'error') {
            Toastify({
                text: text,
                duration: 1500,
                close: false,
                gravity: "top",
                backgroundColor: "linear-gradient(to right, #f44336, #e91e63)",
            }).showToast();
        }
    }
</script> --}}
@if(isset($active_ticket))
    <script type="text/javascript">
        // refresh ticket
        $(document).ready(function() { ticket_show(ticket_id); });
        setInterval(function() { ticket_show(ticket_id); }, 3000);
    </script>
@endif
<script type="text/javascript">

    // js for review
    $('.review-ticket').click(function(){

        $('body').addClass('active-review');
        $('.review-section').show();
        $('html, body').animate({
            scrollTop: $('.review-section').offset().top - 100
        }, 10);
    })
    // show password
    // function showpass(id, btn) {
    //   var pass = $(id).attr("type");
    //   if (pass == "password") {
    //     $(id).attr("type", "text");
    //     $(btn).html('<i class="fa fa-eye"></i>');
    //   } else {
    //     $(id).attr("type", "password");
    //     $(btn).html('<i class="fa fa-eye-slash"></i>');
    //   }
    // }

    function createTicketModal() {
        $('#create_ticket_modal').modal('show');
        // submit ticket form
        $(".create_ticket_form").on('submit', function(e) {
            e.preventDefault();

            $("#waitModal").show();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/ticket/create',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {

                    if (response[0] == 'error') {
                        // msg('error', response[1]);
                    } else {
                        // msg('success', response[1]);
                        $('#create_ticket_modal').modal('hide');
                        $(".create_ticket_form").trigger("reset");
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                }
            });
        });
    }

    //  show message function
    function get_ticket(id) {
        $("#ticket_lticket_ist a").removeClass("active_ticket");
        $("#ticket_" + id).addClass("active_ticket");
        ticket_show(id)
    }


    function ticket_show(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "post",
            url: "{{ url('/ticket/show/') }}",
            data:{id: id},
            success: function(data) {
                console.log(id);
                if (data[0] == "success") {
                    $('#message_box').html(data[1]);
                    if (data[2] == 1) {
                        $('.message_form').show();
                        $('.close_ticket').attr("style", "display: flex !important");
                    } else {
                        $('.message_form').hide();
                        $('.close_ticket').attr("style", "display: none !important");
                    }
                    $('#ticket_id').val(data[3]);
                     $('.ticket_id').val(data[3]);

                    $('.ticket_title').text('#'+id);
                }
            }
        });
    }


    function close_ticket() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: "{{ url('/ticket/close') }}",
            data: {id:id},
            success: function(data) {
                setTimeout(function() {
                    location.reload();
                }, 200);
                // msg('success', response[1]);
            }
        });
    }

    function ticketFindMessage(){
        // msg('error', 'You have an active account, please clost active accoount. ');
        alert('You have an active ticket, please close active ticket first.');
    }

</script>

@endpush
