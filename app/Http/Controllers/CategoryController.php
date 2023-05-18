<?php

namespace App\Http\Controllers;

use App\Models\AdministratorLog;
use App\Models\Category;
use App\Models\Magician;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->type == 3)
        {
            $categoryC = Category::where('deleted_at', null)->get();
            $category = Category::where('deleted_at', null)->where('parent_id', null)->latest()->get();
            return view('FrontEnd.AdminPanel.categories',compact('category','categoryC'));
        }else{
            return redirect('/dashboard');
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
        $request->validate([ 'name' => 'required|unique:categories|max:144', ]);

        // $product  = Product::where('name', $request->name)->first();
        // if(isset($product))
        // {
        //     $input['slug'] = Str::slug($request->name.'-'.rand(111,777));
        // }else{
        //     $input['slug'] = Str::slug($request->name);
        // }
        $input = $request->all();
        $input['slug'] = Str::slug($request->name);
        if($request->parent_id != null)
        {
           $input['parent_id'] = $request->parent_id;
        } else { unset($input['parent_id']); }
        Category::create($input);

        // ================ create administrator log
        $user = Auth::user();
        // 0=user, 1=vendor, 2=support, 3=admin

        switch ($user->type) {
            case 0:
                $type = 'User';
                break;
            case 1:
                $type = 'Vendor';
                break;
            case 2:
                $type = 'Support';
                break;
            case 3:
                $type = 'Admin';
                break;

            default:
                $type = 'Other';
                break;
        }

        AdministratorLog::create([
            'user_id' => $user->id,
            'type' => 'Create',
            'description' => 'Category Created',
            'user' => $type,
        ]);

        return redirect()->back()->with('success','Category Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $original_id = Magician::ed($id,false);
        $cate = Category::find($original_id);

        //   if have sub cate
        $catSub = Category::where('deleted_at', null)->where('parent_id', $cate->id)->get();
        foreach($catSub as $item)
        {
            $cate->delete();
            $item->delete();
        }

        // ================ administrator log
        $user = Auth::user();
        // 0=user, 1=vendor, 2=support, 3=admin

        switch ($user->type) {
            case 0:
                $type = 'User';
                break;
            case 1:
                $type = 'Vendor';
                break;
            case 2:
                $type = 'Support';
                break;
            case 3:
                $type = 'Admin';
                break;

            default:
                $type = 'Other';
                break;
        }

        AdministratorLog::create([
            'user_id' => $user->id,
            'type' => 'Remove',
            'description' => 'Category Deleted',
            'user' => $type,
        ]);


        return redirect()->back()->with('success','Category Deleted');
    }
}
