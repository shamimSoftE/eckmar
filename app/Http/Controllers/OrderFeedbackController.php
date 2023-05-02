<?php

namespace App\Http\Controllers;

use App\Models\OrderFeedback;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderFeedbackController extends Controller
{
    // review button 1 for positive 2 for neutral 0 for negetive
    public function storeFeedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "review_button" => 'required',
            "quality_review" => 'required',
            "shipping_review" => 'required',
            "feedback_message" => 'required|max:250'
        ]);

        if ($validator->fails())
        {
            return back()->with('error', $validator->errors()->first());
        }
        $input = $request->all();

        try {
            $product = Product::find($input['product_id']);
            $input['seller_id'] = $product->seller_id;

            $order_feedback = OrderFeedback::where('product_id', $request->product_id)->latest()->first();

            if(isset($order_feedback->id))
            {
                if($request->review_button == 1)
                {
                    $input['review_positive'] = 1 + $order_feedback->review_positive;
                }else{
                    $input['review_positive'] = $order_feedback->review_positive;
                }

                if($request->review_button == 2){
                    $input['review_neutral'] = 1 + $order_feedback->review_neutral;
                }else{
                    $input['review_neutral'] =   $order_feedback->review_neutral;
                }

                if($request->review_button == 0){
                    $input['review_negative'] = 1 + $order_feedback->review_negative;
                }else{
                    $input['review_negative'] = $order_feedback->review_negative;
                }
            }else{
                if($input['review_button'] == 1)
                {
                    $input['review_positive'] = 1;
                }else{
                    $input['review_positive'] = 0;
                }

                if($input['review_button'] == 2)
                {
                    $input['review_neutral'] =   1;
                }else{
                    $input['review_neutral'] =   0;
                }

                if($input['review_button'] == 0)
                {
                    $input['review_negative'] = 1;
                }else{
                    $input['review_negative'] = 0;
                }
            }
            // dd($input);

            $input['customer_id'] = Auth::user()->id;

            OrderFeedback::create($input);

        } catch (\Throwable $th) {
            return redirect()->back();
        }
        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }
}
