<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('FrontEnd.pages.wallet');
    }

    public function withdraw(Request $request)
    {
        if ($request->request_withdraw == null) {
            $request_withdraw = $request->total_withdraw;
        }else{
            $request_withdraw = $request->request_withdraw;
        }

        if ($request_withdraw == 0) {
            return redirect()->back()->with('error', 'Please Insert a Valid Amount');
        }

        $user = Auth::user();

        try {
            $wallet = Wallet::where('user_id',$user->id)->first();
            if ($wallet->balance >= $request_withdraw) {
                Withdraw::create([
                    'amount' => $request_withdraw,
                    'vendor_id' => $user->id,
                    'amount_type' => 'dollar',
                ]);
                $new_balance = $wallet->balance - $request_withdraw;
                $wallet->update(['balance' => $new_balance]);
                return redirect()->back()->with('success', 'Your Request To Withdraw Amount Is Now Pending');
            }else{
                return redirect()->back()->with('error', 'Please Insert A Valid Amount');
            }

        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
