<?php

namespace App\Http\Controllers;

use App\Models\Disputes;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DisputesController extends Controller
{
    public function send_sms(Request $request)
    {
        $input = $request->all();
        if($input['message'] == null)
        {
            return redirect()->back()->with('error', 'Please write something to start disputes');
        }else{
            Disputes::create($input);
        }
        return redirect()->back();
    }

    public function get_dispute_sms(Request $request)
    {
        try {
            $order = Order::find($request->id);
            $dispute = Disputes::where('order_id',$order->id)->latest()->get();
            $dis_sms = '';
            foreach($dispute as $dis)
            {
                $name = '';
                if($dis->support_id == null)
                {
                    $name = User::find($dis->customer_id)->name;
                }else{
                    $name = User::find($dis->support_id)->name;
                }
                //     $name = User::find($dis->customer_id)->name;
                //     $dis_sms .= '<div style=" margin-bottom: 5px!important;">
                //             <span class="border float-start w-100 d-flex p-1 mb-2">
                //                 '.$dis->message.' <small style="font-size: .75em;color: #0e8b0e; margin: 5px 0 0 18px;">&lt;---  '.$dis->created_at->diffForHumans().' by <b>'.$name.'</b></small>
                //             </span>
                //         </div>';
                // }else{
                //     $name = User::find($dis->support_id)->name;
                //     $dis_sms .= '<div style=" margin-bottom: 5px!important;">
                //             <span class="border float-start w-100 d-flex p-1 mb-2">
                //                 '.$dis->message.' <small style="font-size: .75em;color: #0e8b0e; margin: 5px 0 0 18px;">&lt;---  '.$dis->created_at->diffForHumans().' by <b>'.$name.'</b></small>
                //             </span>
                //         </div>';
                // }
                $dis_sms .= '<div style=" margin-bottom: 5px!important;">
                <span class="border float-start w-100 d-flex p-1 mb-2">
                    '.$dis->message.' <small style="font-size: .75em;color: #0e8b0e; margin: 5px 0 0 18px;">&lt;---  '.$dis->created_at->diffForHumans().' by <b>'.$name.'</b></small>
                </span>
            </div>';
            }
            return $dis_sms;
        } catch (\Throwable $th) {
            return 'dd';
        }
    }
}
