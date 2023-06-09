<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function dashboard()
    {
        if(Auth::user()->type == 3)
        {
            $data['total_product'] = Product::where('deleted_at',null)->count();

            $data['total_user_register'] = User::where('deleted_at',null)->where('type',0)->count();
            $data['total_vendor'] = User::where('deleted_at',null)->where('type',1)->count();
            $data['total_support'] = User::where('deleted_at',null)->where('type',2)->count();

            $data['total_pending_order'] = Order::where('deleted_at',null)->where('status',0)->count();
            $data['total_dispute_order'] = Order::where('deleted_at',null)->where('status',3)->count();
            $data['total_cancel_order'] = Order::where('deleted_at',null)->where('status',4)->count();
            $data['total_completed_order'] = Order::where('deleted_at',null)->where('status',4)->count();
            $data['total_order'] = Order::where('deleted_at',null)->count();

            // Count the number of orders within the last 24 hours
            $data['purchase_last_24h'] = Order::where('created_at', '>=', Carbon::now()->subHours(24))->count();
            $data['purchase_last_week'] = Order::where('created_at', '>', Carbon::now()->subWeek())->count();
            $data['purchase_last_month'] = Order::whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()])->count();

            $data['top_product'] = Product::where('deleted_at',null)->where('order_count', '!=', null)->get();
            $data['top_category'] = Category::where('deleted_at',null)->where('order_count', '!=', null)->get();


            return view('FrontEnd.AdminPanel.dashboard',compact('data'));
        }else{
            return redirect('/dashboard');
        }
    }


    public function adminOrder()
    {
        $data['orders'] = Order::where('deleted_at', null)->latest()->paginate(5);
        $data['order_process'] = Order::where('deleted_at', null)->where('status', 0)->latest()->paginate(5);
        $data['order_complete'] = Order::where('deleted_at', null)->where('status', 1)->latest()->paginate(5);
        $data['order_delivered'] = Order::where('deleted_at', null)->where('status', 2)->latest()->paginate(5);
        $data['order_disputes'] = Order::where('deleted_at', null)->where('status', 3)->latest()->paginate(5);
        $data['order_cancell'] = Order::where('deleted_at', null)->where('status', 4)->latest()->paginate(5);

        // dd(count($data['orders']),count( $data['order_process']), count($data['order_complete']), count($data['order_delivered']), count($data['order_disputes']), count( $data['order_cancell']));

        return view('FrontEnd.AdminPanel.seller_all_order',compact('data'));
    }
}
