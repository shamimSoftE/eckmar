<?php

namespace App\Http\Controllers;

use App\Models\Disputes;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupportController extends Controller
{
    public function supportPanel()
    {
        $disputes = Disputes::latest()->get()->keyBy('customer_id');

        return view('FrontEnd.support.support_page',compact('disputes'));
    }
    public function adminTicket()
    {
        // $data["tickets"] = TicketMessage::select('ticket_messages.id','ticket_messages.created_at','ticket_messages.message','ticket_messages.ticket_id','tickets.status','users.avatar','users.first_name','users.last_name')
        $data["tickets"] = TicketMessage::select('ticket_messages.id','ticket_messages.created_at','ticket_messages.message','ticket_messages.ticket_id','tickets.status','tickets.cat_id','users.name')
        ->orderBy('id','DESC')
        ->leftJoin('tickets','ticket_messages.ticket_id' ,'=', 'tickets.id')
        ->leftJoin('users','tickets.user_id' ,'=', 'users.id')
        ->get()
        ->groupBy('ticket_id');

        return view('FrontEnd.support.ticket_list',compact('data'));
    }

    public function get_message($id){
        try {
            $ticket = Ticket::find($id);


            if($ticket->user->avatar !=null)
            {
                $image_link = ' <img  src="'.asset("assets/images/avatars/".$ticket->user->avatar).'" alt="avatar" height="36" width="36" /><span class="avatar-status-online"></span>';
            }else{
                $image_link = '<img  src="'.asset("assets_v3/customer/avatar-place.png").'" alt="avatar" height="36" width="36"/><span class="avatar-status-online"></span>';
            }

            $message_html = "";

            if(isset($ticket->message))
            {
                foreach ($ticket->message as $message) {
                    $created_at = Carbon::parse($message->created_at);
                    $time = $created_at->format('h:i A');
                    $date = $created_at->format('d/m/y');

                    $img = "";

                    if($message->message !=null){
                        $sms =  $message->message;
                    }else{
                        $sms = '';
                    }

                    if ($message->reply_id == 0) {

                        // if($ticket->user->avatar !=null)
                        // {
                        //     $avatar = '<img  src="'.asset("assets/images/avatars/".$ticket->user->avatar).'" alt="avatar" height="36" width="36"/>';
                        // }else{
                        //     $avatar = '<img  src="'.asset("assets_v3/customer/avatar-place.png").'" alt="avatar" height="36" width="36"/>';
                        // }

                        $message->update(['read'=>1]);

                        $message_html .= ' <div class="media w-50 ml-auto d-flex justify-content-end">
                        <div class="media-body text-end">
                            ' . $img .'
                            <div class="mb-2">
                                <div style="background: #198754;" class=" pt-1 p-2 px-3 w-auto">
                                    <p class="text-small mb-0 text-white d-inline">'.$sms.'</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="media w-50 ml-auto d-flex justify-content-end">
                        <p class="small text-muted text-end"> <i class="fa fa-calendar" aria-hidden="true"></i> ' . $date . ' <i class="fa fa-clock-o" aria-hidden="true"></i> ' . $time . ' </p>
                    </div> ';

                    } else {
                        $message_html .= '<div class="media w-50 d-flex" style="align-items: flex-start;">
                        <div class="media-body ms-1 text-start">
                            <div class="mb-1">
                                <small class="small text-success bg-soft-success">
                                    <i class="fa fa-user-circle-o" aria-hidden="true"></i> ' .@$message->user->name.'
                                </small>
                            </div>
                            '. $img . '
                            <div class="mb-2">
                                <div class="bg-secondary pt-1 p-2 px-3 w-100">
                                    <p class="text-small mb-0 text-white d-inline">'.$sms.'</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="media w-50 d-flex" style="align-items: flex-start;">
                        <p class="small text-muted"> <i class="fa fa-calendar" aria-hidden="true"></i> ' . $date . ' <i class="fa fa-clock-o" aria-hidden="true"></i> ' . $time . ' </p>
                    </div>';
                    }
                }
            }

            if($ticket->status==2){
                $review = '';
                for($i=1;$i<=5;$i++){
                    if($i <=$ticket->review_star){
                        $review .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#f78000" class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                      </svg>';
                    }else{
                        $review .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ccc" class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                      </svg>';
                    }
                }

                $message_html .=  '<hr> <div class="text-center bg-white p-2 ">
                <h4>Review</h4>
                <div class="ticket_review">
                 <div class="rating">
                      '.$review.'
                </div> '.$ticket->review_message.' </div> </div>';
            }

            return response(['success', $message_html,$ticket,$image_link]);
        } catch (\Throwable $th) {
        }
    }

    public function unread_message(){
        $tickets = Ticket::latest()->get();
        $html_data = '';
        foreach($tickets as $ticket){
            $data[]= ["ticket_id"=> $ticket->id, "unread"=>count($ticket->unread)];
        }
        return response(['success', $data]);
    }

    public function reload_ticket(){
        $data["tickets"] = TicketMessage::select('ticket_messages.id','ticket_messages.created_at','ticket_messages.message','ticket_messages.ticket_id','tickets.status','users.avatar','users.name')
        ->orderBy('id','DESC')
        ->leftJoin('tickets','ticket_messages.ticket_id' ,'=', 'tickets.id')
        ->leftJoin('users','tickets.user_id' ,'=', 'users.id')
        ->get()
        ->groupBy('ticket_id');


        $html_data = "";
        $unread = "";
        foreach($data["tickets"] as  $ticket){
            $ticket = $ticket[0];

            $unread = \App\Models\TicketMessage::where('ticket_id', $ticket->ticket_id)->where('read',0)->where('reply_id',0)->count();

            if($unread>0){
                $unread =$unread;
            }else{
                $unread ='';
            }

            if($ticket->status==1){
                $status = 'avatar-status-online';
            }else{
                $status = 'avatar-status-offline';
            }

            if(isset($ticket->user) && $ticket->user->avatar != null)
            {
                $img = '<img src="'.asset('assets/images/avatars/' . $ticket->user->avatar).'" height="42" width="42" alt="Generic placeholder image" />';
            }else{
                $img = '<img src="'.asset('assets/images/portrait/small/avatar.jpg').'" height="42" width="42" alt="Generic placeholder image" />';
            }

            $html_data .= '<li onclick="get_message('.$ticket->ticket_id.')" class="active_ticket_'.$ticket->ticket_id.' ticket_list">
            <span class="avatar">'.$img.' <span class="'.$status.'"></span>

            </span>
            <div class="chat-info flex-grow-1">
                <h5 class="mb-0">'.'#'.$ticket->ticket_id.' | '.$ticket->first_name.'
                    '.$ticket->last_name.'</h5>
                <p class="card-text text-truncate">
                    '.$ticket->message.'
                </p>
            </div>
            <div class="chat-meta" style="width: 70px">
                <small class="float-right mb-25 chat-time">'.date('h:i A',strtotime(@$ticket->message->created_at)).'</small>
                <span class="badge badge-danger float-right unread_message_'.$ticket->ticket_id.'">'.$unread.'</span>
            </div>
        </li>';
        }

        return response(['success',$html_data]);
    }

    public function reply_message(Request $request){
        if (isset($request->message) || !empty($request->images)) {
            $input = $request->all();

            $input['reply_id'] = Auth::user()->id;
            // dd($input);
            TicketMessage::create($input);
            return response(['success', 'Your tickets created success']);
        } else {
            return response(['error', "Please write something"]);
        }
    }
}
