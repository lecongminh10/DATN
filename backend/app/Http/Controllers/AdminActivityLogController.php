<?php

namespace App\Http\Controllers;

use App\Models\UserActivityLog;

class AdminActivityLogController extends Controller
{
    public function index()
    {
        $logs = UserActivityLog::with('user')
            ->orderBy('created_at', 'desc') 
            ->simplePaginate(7); 

        return view('admin.logs.index', compact('logs'));
    }
}


