<?php

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;

class LogActivity
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // บันทึก Log ทุกการกระทำ
        Log::create([
            'kkumail' => Auth::check() ? Auth::user()->email : 'Guest',
            'action' => $request->method() . ' ' . $request->path(),
            'date_time' => now()
        ]);

        return $response;
    }
}
