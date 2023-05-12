<?php

namespace App\Http\Controllers;

use App\Models\Magician;
use App\Models\Product;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $wishlist = Wishlist::where('open_by', Auth::user()->id)->latest()->get();
            return view('FrontEnd.pages.wishlist',compact('wishlist'));
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

    public function addWishlist($id)
    {
        $user = Auth::user();
        try {
                $userBanUntill = Carbon::parse($user->banned_until);
                $today = Carbon::now();
                $dayDiff = $today->diffInDays($userBanUntill);


            if($dayDiff <= 1)
            {
                $product = Product::find(Magician::ed($id,false));
                $already_listed = Wishlist::where('product_id', $product->id)->where('open_by', $user->id)->first();
                if(isset($already_listed))
                {
                    return redirect()->back()->with('error','Product Already Added');
                }else{
                    Wishlist::create([
                        'product_id' => $product->id,
                        'open_by' => $user->id,
                    ]);
                    return redirect()->back()->with('success','Product Added To Wishlist');
                }
            }else{
                return redirect()->back()->with('error',"Your Account Was Banned. So You Can't Access This Field Right Now. It Will Be Remove On ".date('d M Y', strtotime($user->banned_until)));
            }
        } catch (\Throwable $th) {
            return redirect()->back();
        }
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
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        try {
            $wishItem = Wishlist::where('id', Magician::ed($id,false))->where('open_by', $user->id)->first();

            $wishItem->delete();
            return redirect()->back()->with('success','Product Remove From Wishlist');
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
}
