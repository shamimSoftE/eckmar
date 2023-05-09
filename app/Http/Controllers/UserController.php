<?php

namespace App\Http\Controllers;

use App\Models\BanUser;
use App\Models\Magician;
use App\Models\OrderFeedback;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile($id)
    {
        $uid = sha1(Auth::user()->id);
        if($id ==$uid )
        {
           return view('FrontEnd.pages.profile');
        }else{
            return redirect()->back()->with('error', 'This service is not available. Pleas Try Again Later');
        }
    }

    public function updatePass(Request $request)
    {
        $user = Auth::user();

        // if (Hash::check($user->password, $request->password)) {
        //     dd('ok');
        //    }
        $value = $request->password;
           $request->validate([
            'password' => 'required|min:8',
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
        ]);

       User::find($user->id)->update(['password' => Hash::make($request->password)]);


        // $user->update();

        return back()->with('success', 'Password updated');
    }

    public function userList()
    {
        $users = User::where('type', '!=', 3)->latest()->get();
        return view('FrontEnd.AdminPanel.user_list',compact('users'));
    }

    // order_by 1 = newest, 0 = oldest
    // type 0 = user, 1 = vendor, 2 = support/administrative 5 = everyone [ except 3 = admin ].
    public function userFilter(Request $request)
    {
        $input = $request->all();

        $users = User::where('deleted_at', null)->where('type', '!=', 3);
        if($input['username'] != null)
        {
            $users = $users->where('name','like', $input['username']);
        }elseif($input['type'] != null){
            switch ($input['type']) {
                case 0:
                    $users = $users->where('type', 0);
                    break;
                case 1:
                    $users = $users->where('type', 1);
                    break;
                case 2:
                    $users = $users->where('type', 2);
                    break;

                default:
                    $users = $users->where('type', '!=', 3);
                    break;
            }
        }elseif($input['order_by'] != null) {
            if ($input['order_by'] == 1) {
                $users = $users->latest();
            }
        }
        $users = $users->get();
        return view('FrontEnd.AdminPanel.user_list',compact('users','input'));
    }

    public function userDetail($id)
    {
        $user = User::find(Magician::ed($id, false));
        $bans = BanUser::where('user_id', $user->id)->latest()->get();

        if ($user->type == 1) {
            $order_feedback = OrderFeedback::where('seller_id', $user->id)->latest()->first(['review_positive','review_neutral','review_negative']);
            $product_reviews = OrderFeedback::where('seller_id', $user->id)->get(['feedback_message','customer_id','seller_id','quality_review','shipping_review']);
            return view('FrontEnd.AdminPanel.vendor_details', compact('user', 'bans','order_feedback','product_reviews'));
        }else{
            return view('FrontEnd.AdminPanel.user_details', compact('user','bans'));
        }
    }

    public function userPermission(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        if ($request->user_type_dispute == 2) {
            $type = 2;
            $panel_support = 1;
        }else{
            $type = $user->type;
            $panel_support = 0;
        }

        if ($request->user_type_vendor == 1) {
            $type = 1;
        }else{
            $type = $user->type;
        }

        if ($request->user_type_vendor == 1 &&  $type == 2) {
            $user->update([
                'type' => 1,
                'vendor_since' => 1,
                'support_panel' => date('Y-m-d H:m:s')
            ]);
        }else {
            $user->update([
                'type' => 1,
                'support_panel' => 0,
            ]);
        }

        return redirect()->back()->with("success", 'User panel permission saved');
    }

    public function userWalletModify(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $user_wallet = Wallet::where('user_id', $user->id)->first();
        $user_wallet->update(['balance' => $request->balance_dollar]);
        return redirect()->back()->with("success", 'User wallet updated');
    }

    public function userBanned(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        BanUser::create([
            'user_id' => $user->id,
            'end_date' => now()->addDays($request->ban_for),
        ]);
        $user->update(['banned_until' => now()->addDays($request->ban_for)]);
        return redirect()->back()->with("success", 'User banned for ' .$request->ban_for.' days.');
    }
}
