<?php

namespace App\Http\Controllers;

use App\Models\Magician;
use App\Models\MirrorLinks;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MirrorLinkController extends Controller
{
    public function index()
    {
        $mirror_links = MirrorLinks::latest()->paginate(10);
        return view('FrontEnd.AdminPanel.mirror_link',compact('mirror_links'));
    }

    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'title' => 'required',
            'link' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }
        $input = $request->all();
        MirrorLinks::create($input);
        return redirect()->back()->with('success', 'Link Created');
    }

    public function edit(Request $request)
    {
        $links = MirrorLinks::find($request->id);
        return $links;
    }

    public function update(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'title' => 'required',
            'link' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }
        try {
            $input = $request->all();
            MirrorLinks::find($request->id)->update($input);
            return redirect()->back()->with('success', 'Link Updated');
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
       try {
            $news_id = Magician::ed($id, false);
            MirrorLinks::find($news_id)->delete();
            return redirect()->back()->with('success', 'Link Deleted');
       } catch (\Throwable $th) {
            return redirect()->back();
       }
    }
}
