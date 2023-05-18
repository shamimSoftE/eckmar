<?php

namespace App\Http\Controllers;

use App\Models\AdministratorLog;
use Illuminate\Http\Request;

class AdministratorLogController extends Controller
{
    public function index()
    {
        $logs = AdministratorLog::latest()->get();
        return view('FrontEnd.AdminPanel.administrator_log', compact('logs'));
    }
}
