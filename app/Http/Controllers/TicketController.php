<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketMessage;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function supportTicket()
    {
        $categorys = TicketCategory::get();
        $tickets = Ticket::where('user_id', Auth::user()->id)->latest()->get();
        $active_ticket = Ticket::where('user_id', Auth::user()->id)->where('status', 1)->first();
        return view('FrontEnd.pages.ticket', compact('categorys', 'tickets','active_ticket'));
    }

    public function create()
    {
        //
    }

    public function support_ticket_create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "cat_id" => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error', $validator->errors()->first()]);
        }

        if(isset($request->message) || !empty($request->images)){
            $input = $request->all();
            if (!empty($request->images)) {

                foreach ($request->images as $key => $value) {
                    if ($request->file('images')[$key]) {
                        $imageName = date('YmdHis') . rand(1111, 9999) . '.' . $request->images[$key]->extension();
                        $request->images[$key]->move(public_path('uploads/tickets'), $imageName);
                        $image[] = $imageName;
                    }
                }
                $input['images'] = json_encode($image);
            }

            $input['user_id'] = Auth::user()->id;
            // dd($input);
            $ticket =  Ticket::create($input);

            $input['ticket_id'] = $ticket->id;
            TicketMessage::create($input);

            return response(['success', 'Your tickets created success']);
        }else{
            return response(['error', "Please write something"]);
        }
    }

    public function send_message(Request $request)
    {
        if (isset($request->message) || !empty($request->images)) {
            $input = $request->all();

            $input['user_id'] = Auth::user()->id;
            TicketMessage::create($input);
            return response(['success', 'Your tickets created success']);
        } else {
            return response(['error', "Please write something"]);
        }
    }

    public function ticket_show(Request $request)
    {
        try {
            $ticket = Ticket::find($request->id);
            // dd($ticket);
            $message_html = "";
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
                    $message_html .= '<div class="media w-50 ml-auto d-flex justify-content-end">
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
                                    </div>';
                } else {
                    $message_html .= '<div class="media w-50 d-flex" style="align-items: flex-start;">
                                            <div class="media-body ms-1 text-start">
                                                <div class="mb-1">
                                                    <small class="small text-success bg-soft-success">
                                                        <i class="fa fa-user-circle-o" aria-hidden="true"></i> ' . @$message->user->name.' '. @$message->user->name.'
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

                $message_html .=  '<hr> <div class="text-center bg-white p-2">
                <h4>Review</h4>
                <div class="ticket_review">
                 <div class="rating">
                      '.$review.'
                </div> '.$ticket->review_message.' </div> </div>';
            }

            $id = $request->id;

            return response(['success', $message_html, $ticket->status, $id]);
        } catch (Exception $e) {
        }
    }


   public function ticket_close(Request $request)
    {
        try{
            $input = $request->all();
            $input['status'] = 2;
            $ticket = Ticket::find($request->id);
            $ticket->update($input);
            return redirect()->back()->with('success', 'Thank you for your review');
        }catch(Exception $e){
            return redirect()->back()->with('error', 'Something wrong');
        }
    }
}
