<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;

class LogAdminController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')
            ->orderByDesc('created_at')
            ->limit(200)
            ->get();

        return view('admin.logs.index', [
            'logs' => $logs,
        ]);
    }
}
