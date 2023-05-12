<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Magician;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $userBanUntill = Carbon::parse($user->banned_until);
        $today = Carbon::now();
        $dayDiff = $today->diffInDays($userBanUntill);

        if ($dayDiff <= 1) {
            $products = Product::where('deleted_at', null)->where('seller_id', $user->id)->paginate(7);
            return view('FrontEnd.pages.seller.product_list',compact('products'));
        }else {
            return redirect()->back()->with('error', "Your Account Was Banned. So You Can't Access This Field Right Now. It Will Be Remove On ".date('d M Y', strtotime($user->banned_until)));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $userBanUntill = Carbon::parse($user->banned_until);
        $today = Carbon::now();
        $dayDiff = $today->diffInDays($userBanUntill);

        if ($dayDiff <= 1) {
            $category = Category::where('deleted_at', null)->where('status',1)->get();
            return view('FrontEnd.pages.seller.add_product',compact('category'));
        }else {
            return redirect()->back()->with('error', "Your Account Was Banned. So You Can't Access This Field Right Now. It Will Be Remove On ".date('d M Y', strtotime($user->banned_until)));
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
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'qty' => 'required',
            'category_id' => 'required',
            'image' => 'required',
        ]);

        $input = $request->all();

        if ($request->file('image')) {
            $imageName = date('Y-m-d_His') . '.' . $request->image->extension();
            $request->image->move(public_path('assets/images/product'), $imageName);
            $input['image'] = $imageName;
        } else {
            unset($input['image']);
        }

        $input['seller_id']  = Auth::user()->id;
        $product  = Product::where('name', $request->name)->first();
        if(isset($product))
        {
            $input['slug'] = Str::slug($request->name.'-'.rand(111,777));
        }else{
            $input['slug'] = Str::slug($request->name);
        }



        Product::create($input);
        return redirect()->back()->with('success', 'Product Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $uid = Magician::ed($id,false);

        try {
            $product = Product::find($uid);
        } catch (\Throwable $th) {
            $product = '';
        }
        $category = Category::where('deleted_at', null)->where('status',1)->get();
        return view('FrontEnd.pages.seller.edit_product',compact('product','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'qty' => 'required',
            'category_id' => 'required',
        ]);
        $pro = Product::find(Magician::ed($id,false));

        $input = $request->all();
        if ($request->file('image')) {
            $imageName = date('Y-m-d_His') . '.' . $request->image->extension();
            $request->image->move(public_path('assets/images/product'), $imageName);
            $input['image'] = $imageName;

            $old_path_img = public_path('assets/images/product/'.$pro->image);
            if(file_exists($old_path_img))
            {
                @unlink($old_path_img);
            }
            $input['image'] = $imageName;
        } else {
            unset($input['image']);
        }

        $product  = Product::where('name', $request->name)->where('id', '!=', $pro->id)->first();
        if(isset($product))
        {
            $input['slug'] = Str::slug($request->name.'-'.rand(111,777));
        }else{
            $input['slug'] = Str::slug($request->name);
        }

        $input['seller_id']  = Auth::user()->id;
        $pro->update($input);
        return redirect()->back()->with('success', 'Product Updated');
    }

    public function autofill($id)
    {
        $product = Product::find(Magician::ed($id,false));

        return view('FrontEnd.pages.seller.add_autofill',compact('product'));
    }

    public function updateAutofill(Request $request,$id)
    {
        $pro = Product::find(Magician::ed($id,false));
        $pro->update(['content' => $request->content]);
        // dd( $request->all());
        return redirect('product_list')->with('success', 'Autofill Added');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,$id)
    {
        $pro = Product::find(Magician::ed($id,false));

        if(isset($pro->image))
        {
            $old_path_img = public_path('assets/images/product/'.$pro->image);
            if(file_exists($old_path_img))
            {
                @unlink($old_path_img);
            }
        }
        $pro->delete();
        return redirect()->back()->with('success', 'Product Deleted');
    }

    // product filter
    public function filter(Request $request)
    {
        $input = $request->all();

        $data['products'] = Product::where('status',1)->where('deleted_at', null);
        if($input['product_name'] != null)
        {
            $data['products'] = Product::where('name','like', $input['product_name']);

        }elseif($input['min_price'] != null && $input['max_price'] != null){
            $data['products'] =  $data['products']->where('price', '>=', $input['min_price'])->where('price', '<=', $input['max_price']);

        }elseif(@$input['auto_delivery'] != null){
            $data['products'] =  $data['products']->where('auto_delivery', 1);

        }elseif(@$input['low_high'] != null && @$input['low_high'] == 1){
            $data['products'] =  $data['products']->orderBy('price', 'asc');

        }elseif(@$input['low_high'] != null && @$input['low_high'] == 2){
            $data['products'] =  $data['products']->orderBy('price', 'desc');
        }

        $data['products'] =  $data['products']->get();
        $data['category'] = Category::where('status', 1)->where('deleted_at',null)->get();
       return view('FrontEnd.pages.product_filter',compact('data'));
    }









    // ------------------------- admin panel ---------------------

    public function adminProductLlst()
    {
        $products = Product::where('deleted_at', null)->latest()->get();
        return view('FrontEnd.AdminPanel.admin_product_list',compact('products'));
    }

    public function adminProductFilter(Request $request)
    {
        $input = $request->all();

        $products = Product::where('deleted_at', null);

        if($input['product_name'] != null)
        {
            $products =  $products->where('name','like', '%'. $input['product_name'].'%');
        }elseif($input['vendor_name'] != null){
            try {
                $user = User::where('name', $input['vendor_name'])->first();
                $products =  $products->where('seller_id', $user->id);
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Vendor Not Found');
            }
        }elseif($input['order_by'] != null) {
            if ($input['order_by'] == 1) {
                $products = $products->latest();
            }
        }
        $products = $products->get();
        return view('FrontEnd.AdminPanel.admin_product_list',compact('products','input'));
    }

    public function adminProductEdit($id)
    {
        $product = Product::find(Magician::ed($id,false));
        $category = Category::where('deleted_at', null)->get();
        return view('FrontEnd.AdminPanel.admin_product_edit', compact('product','category'));
    }

    public function adminProductUpdate(Request $request,$id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'qty' => 'required',
            'category_id' => 'required',
        ]);
        $pro = Product::find(Magician::ed($id,false));

        $input = $request->all();

        if (isset($input['auto_delivery'])) {
            $input['auto_delivery'] = $input['auto_delivery'];
        }else{
            $input['auto_delivery'] = 0;
        }

        if (isset($input['unlimited'])) {
            $input['unlimited'] = $input['unlimited'];
        }else{
            $input['unlimited'] = 0;
        }

        // dd($input);
        if ($request->file('image')) {
            $imageName = date('Y-m-d_His') . '.' . $request->image->extension();
            $request->image->move(public_path('assets/images/product'), $imageName);
            $input['image'] = $imageName;

            $old_path_img = public_path('assets/images/product/'.$pro->image);
            if(file_exists($old_path_img))
            {
                @unlink($old_path_img);
            }
            $input['image'] = $imageName;
        } else {
            unset($input['image']);
        }

        $product  = Product::where('name', $request->name)->where('id', '!=', $pro->id)->first();
        if(isset($product))
        {
            $input['slug'] = Str::slug($request->name.'-'.rand(111,777));
        }else{
            $input['slug'] = Str::slug($request->name);
        }

        $pro->update($input);
        return redirect()->back()->with('success', 'Product Updated');
    }


    public function adminProductDelete($id)
    {
        $product = Product::find(Magician::ed($id,false));
        // dd($product);
        $product->delete();
        return redirect()->back()->with('success', 'Product Deleted');
    }



}
