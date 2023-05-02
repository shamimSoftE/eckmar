<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Product;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CancelOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel All 12 Hours Process Order';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Order::where('status', 0)->where('created_at', '<', Carbon::now()->subHours(12))->get();
        foreach ($orders as $order) {

            $product = Product::find($order->product_id); // find product
            $cus_wallet = Wallet::where('user_id',$order->customer_id)->first(); // find customer account
            $cus_balance = 0;  // customer balance default
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
            }

            // $order->status = 'disabled';
            // $order->save();
        }
        // return Command::SUCCESS;
        $this->info('Orders disabled successfully!');
    }
}
