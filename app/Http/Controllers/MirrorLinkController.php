<?php

namespace App\Http\Controllers;

use App\Models\AdministratorLog;
use App\Models\Magician;
use App\Models\MirrorLinks;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        AdministratorLog::create(['user_id' => $user->id,'type' => 'Create', 'description' => 'Mirror Link Created', 'user' => $type ]);


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
            AdministratorLog::create(['user_id' => $user->id,'type' => 'Update', 'description' => 'Mirror Link Updated', 'user' => $type ]);

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
            AdministratorLog::create(['user_id' => $user->id,'type' => 'Remove', 'description' => 'Mirror Link Deleted', 'user' => $type ]);

            return redirect()->back()->with('success', 'Link Deleted');
       } catch (\Throwable $th) {
            return redirect()->back();
       }
    }
}
