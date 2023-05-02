<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\Magician;
use App\Models\User;
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
        $bans = Ban::where('user_id', $user->id)->latest()->get();
        if ($user->type == 1) {
            return view('FrontEnd.AdminPanel.vendor_details', compact('user', 'bans'));
        }else{
            return view('FrontEnd.AdminPanel.user_details', compact('user','bans'));
        }
    }
}
