<?php

namespace App\Http\Controllers;

use App\Models\Magician;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    public function index()
    {
        $newsVendor = News::where('type', 1)->latest()->paginate(3);
        $newsMarket = News::where('type', 0)->latest()->paginate(10);
        return view('FrontEnd.AdminPanel.blog',compact('newsVendor', 'newsMarket'));
    }

    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'blog' => 'required',
            'type' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        $input = $request->all();
        $input['header'] = $input['blog'];

        News::create($input);
        return redirect()->back()->with('success', 'Blog Created');
    }

    public function edit(Request $request)
    {
        $blog = News::find($request->id);
        return $blog;
    }

    public function update(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'blog' => 'required',
            'type' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }
        try {
            $input = $request->all();
            $input['header'] = $input['blog'];
            News::find($request->id)->update($input);
            return redirect()->back()->with('success', 'Blog Updated');
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
       try {
            $news_id = Magician::ed($id, false);
            News::find($news_id)->delete();
            return redirect()->back()->with('success', 'Blog Deleted');
       } catch (\Throwable $th) {
            return redirect()->back();
       }
    }
}
