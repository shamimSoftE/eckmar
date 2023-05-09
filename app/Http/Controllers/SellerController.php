<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Order;
use App\Models\OrderFeedback;
use App\Models\Product;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function vendorRequest(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $wallet = Wallet::where('user_id', $user->id)->first();
        if($wallet->balance > 99)
        {
            // deduct vendor fee
            $wallet->balance = $wallet->balance - 100;
            $wallet->update();

            // update user as vendor
            $user->update([
                'type' => 1,
                'vendor_since' => date('Y-m-d H:m:s')
            ]);
        }else{
            return redirect()->back()->with('error', "You don't have enought balance. Please try again later");
        }
        return redirect('/seller-dashboard');
    }

    public function sallerDashboard()
    {
        $user = Auth::user();
        try {
            $seller_balance = Wallet::where('user_id',$user->id)->first();
            $newsVendor = News::where('type', 1)->latest()->paginate(10);

            $order_complete = Order::where('deleted_at', null)->where('seller_id',$user->id)->where('status', 1)->get();
            $order_review = OrderFeedback::where('seller_id',$user->id)->get();
            $order_feedback = OrderFeedback::where('seller_id', $user->id)->latest()->first(['review_positive','review_neutral','review_negative']);
            $product_reviews = OrderFeedback::where('seller_id', $user->id)->get(['feedback_message','customer_id','seller_id','quality_review','shipping_review']);

            $withdraws = Withdraw::where('vendor_id', $user->id)->latest()->get();
        } catch (\Throwable $th) {
           return redirect()->back();
        }

        return view('FrontEnd.pages.seller.saller_dashboard',compact('user','withdraws','seller_balance','newsVendor','order_review','order_feedback','product_reviews','order_complete'));
    }

    public function myOrder()
    {
        $user = Auth::user();
        try {
            $data['orders'] = Order::where('deleted_at', null)->where('seller_id',$user->id)->latest()->paginate(5);
            $data['order_process'] = Order::where('deleted_at', null)->where('seller_id',$user->id)->where('status', 0)->latest()->paginate(5);
            $data['order_complete'] = Order::where('deleted_at', null)->where('seller_id',$user->id)->where('status', 1)->latest()->paginate(5);
            $data['order_delivered'] = Order::where('deleted_at', null)->where('seller_id',$user->id)->where('status', 2)->latest()->paginate(5);
            $data['order_disputes'] = Order::where('deleted_at', null)->where('seller_id',$user->id)->where('status', 3)->latest()->paginate(5);
            $data['order_cancell'] = Order::where('deleted_at', null)->where('seller_id',$user->id)->where('status', 4)->latest()->paginate(5);
        } catch (\Throwable $th) {
           return redirect()->back();
        }
        return view('FrontEnd.pages.seller.seller_order',compact('data','user'));
    }

    public function orderStatus(Request $request)
    {
        Order::find($request->id)->update(['status'=> $request->status ]);
        // return redirect()->back()->with('success', 'Order Status Changed');
        return response()->json(['success', 'Order Status Changed']);
        // dd($request->all());
    }

    public function updateSeller(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->update([
            'title' => $request->title,
            'about' => $request->about,
        ]);
        return redirect()->back()->with('success', 'Seller Information Updated');
    }
}



