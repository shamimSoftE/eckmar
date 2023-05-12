<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CurrancyType;
use App\Models\Disputes;
use App\Models\Magician;
use App\Models\Order;
use App\Models\OrderFeedback;
use App\Models\Product;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function makeOrder(Request $request)
    {
        $user = Auth::user();

        $userBanUntill = Carbon::parse($user->banned_until);
        $today = Carbon::now();
        $dayDiff = $today->diffInDays($userBanUntill);


        $input = $request->all();
        $input['customer_id'] = Auth()->user()->id;
        $input['custom_order_id'] = '#'.rand(11111,99999);

        // find product
        try {
            if($dayDiff <= 1)
            {

                $product = Product::findOrFail($input['product_id']);
                // $category = Category::findOrFail($product->category_id);


                $product_price = $product->price*$input['product_qty'];
                $input['seller_id'] = $product->seller_id;


                $cus_wallet = Wallet::where('user_id',$input['customer_id'])->first(); // find customer account
                $cus_balance = 0;  // customer balance
                if(isset($cus_wallet))
                {
                    $cus_balance = $cus_wallet->balance;
                }

                $ven_wallet = Wallet::where('user_id',$input['seller_id'])->first(); //find vendor account
                $ven_balance = 0; // vendor balance
                if(isset($ven_wallet))
                {
                    $ven_balance = $ven_wallet->balance;
                }


                if($cus_balance >= $product_price)
                {
                    $sell_price = $cus_balance - $product_price;
                    $ven_balance = $ven_balance + $product_price;

                    $ven_wallet->update(['balance' => $ven_balance]); //update seller wallet

                    $cus_wallet->update(['balance' =>  $sell_price]); //update customer wallet
                    Order::create($input);

                    // update category order count
                    // $category_total_order =  $category->order_count + 1;
                    // $category->update(['order_count' => $category_total_order]);

                    // decrease product qty
                    // if($product->qty >= $input['product_qty'])
                    // {
                    //     $product_qty = $product->qty - $input['product_qty'];
                    // }else{
                    //     $product_qty = $product->qty;
                    //     return redirect()->back()->with('error', 'The requested quantity is not available');
                    // }
                    // $product_total_order =  $product->order_count + 1;
                    // $product->update(['order_count' => $product_total_order, 'qty' => $product_qty]);

                    return redirect('order-view')->with('success', "Thanks For Your Order. We'll Contact You As Soon As Possible.");
                }else{
                    return redirect()->back()->with('error', "You Don't have enough balance.");
                }
            }else{
                return redirect()->back()->with('error',"Your Account Was Banned. So You Can't Access This Field Right Now. It Will Be Remove On ".date('d M Y', strtotime($user->banned_until)));
            }

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "You Don't have enough balance. Found some things missing!");
        }
    }


    // -----------------0 for processing, 1 for complete, 2 for shipped/delivered, 3 for disputes and 4 = cancelled -----------------------------------------

    public function orderView()
    {
        $user = Auth::user();
        // for customer
       try {
            $data['orders'] = Order::where('deleted_at', null)->where('customer_id',$user->id)->latest()->paginate(5);
            $data['order_process'] = Order::where('deleted_at', null)->where('customer_id',$user->id)->where('status', 0)->latest()->paginate(5);
            $data['order_complete'] = Order::where('deleted_at', null)->where('customer_id',$user->id)->where('status', 1)->latest()->paginate(5);
            $data['order_delivered'] = Order::where('deleted_at', null)->where('customer_id',$user->id)->where('status', 2)->latest()->paginate(5);
            $data['order_disputes'] = Order::where('deleted_at', null)->where('customer_id',$user->id)->where('status', 3)->latest()->paginate(5);
            $data['order_cancell'] = Order::where('deleted_at', null)->where('customer_id',$user->id)->where('status', 4)->latest()->paginate(5);
            return view('FrontEnd.pages.order_view',compact('data','user'));
        } catch (\Throwable $th) {
            return redirect()->back();
        }

    }

    // public function autoDelivery()
    // {
    //     return view('FrontEnd.pages.order_auto_delivery');
    // }
    public function orderProcess($id)
    {
        try {
            $order = Order::find(Magician::ed($id,false));
            $product = Product::find($order->product_id);
            return view('FrontEnd.pages.order_process',compact('order','product'));
        } catch (\Throwable $th) {
           return redirect()->back();
        }
    }

    public function orderDelivered($id)
    {
        try {
            $order = Order::find(Magician::ed($id,false));
            $product = Product::find($order->product_id);
            return view('FrontEnd.pages.order_delivery',compact('order','product'));
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    public function orderDispute($id)
    {
        try {
            $order = Order::find(Magician::ed($id, false));
            // $order->update(['status' => 4]);
            $disputes_sms = Disputes::where('order_id', $order->id)->latest()->get();
            $product = Product::find($order->product_id);
            return view('FrontEnd.pages.order_dispute',compact('order','product','disputes_sms'));
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    public function orderCancelled($id)
    {
        try {
            $order = Order::find(Magician::ed($id, false));
            $product = Product::find($order->product_id);


            $cus_wallet = Wallet::where('user_id',$order->customer_id)->first(); // find customer account
            $cus_balance = 0;  // customer balance
            if(isset($cus_wallet))
            {
                $cus_balance = $cus_wallet->balance;
            }

            $ven_wallet = Wallet::where('user_id',$order->seller_id)->first(); //find vendor account
            $ven_balance = 0; // vendor balance
            if(isset($ven_wallet))
            {
                $ven_balance = $ven_wallet->balance;
            }

            $product_price = $product->price* $order->product_qty;

            if($ven_balance >= $product_price)
            {
                $ven_balance = $ven_balance - $product_price;
                $sale_price = $cus_balance + $product_price;

                $ven_wallet->update(['balance' => $ven_balance]); //update seller wallet

                $cus_wallet->update(['balance' =>  $sale_price]); //update customer wallet

                $order->update(['status' => 4]);


                  // decrease product qty
                if($product->qty >= $order->product_qty)
                {
                    $product_qty = $product->qty - $order->product_qty;
                }else{
                    $product_qty = $product->qty;
                return redirect()->back()->with('error', 'The requested quantity is not available');
                }

                if ($product->order_count > 0) {
                    $product_total_order =  $product->order_count - 1;
                }else{
                    $product_total_order =  0;
                }

                $product->update(['order_count' => $product_total_order, 'qty' => $product_qty]);

                // remove category from top order
                $category = Category::findOrFail($product->category_id);
                if ($category->order_count > 0) {
                    $category_total_order =  $category->order_count + 1;
                }else{
                    $category_total_order =  0;
                }
                $category->update(['order_count' => $category_total_order]);


                return view('FrontEnd.pages.order_cancelled',compact('order','product'));
            }
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    public function orderComplete($id)
    {
        try {
            $order = Order::find(Magician::ed($id,false));
            $product = Product::find($order->product_id);

            $category = Category::findOrFail($product->category_id);
            $category_total_order =  $category->order_count + 1;
            $category->update(['order_count' => $category_total_order]);

            // decrease product qty
            if($product->qty >= $order->product_qty)
            {
            $product_qty = $product->qty - $order->product_qty;
            }else{
            $product_qty = $product->qty;
            return redirect()->back()->with('error', 'The requested quantity is not available');
            }

            $product_total_order =  $product->order_count + 1;
            $product->update(['order_count' => $product_total_order, 'qty' => $product_qty]);

            return view('FrontEnd.pages.order_complete',compact('order','product'));
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

}
