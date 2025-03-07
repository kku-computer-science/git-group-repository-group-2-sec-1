<?php

namespace App\Helpers;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogHelper
{
    public static function writeLog($action, $details = null)
    {
        Log::create([
            'kkumail' => Auth::user() ? Auth::user()->email : 'guest',
            'action' => $action,
            'details' => $details,
        ]);
    }
}


