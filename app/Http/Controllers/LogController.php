<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{

    public function showLogs(){
        $logs = Activity::orderBy('id', 'desc')->paginate(10);
        return view('logs', [
            'logs' => $logs
    ]);
}
}
