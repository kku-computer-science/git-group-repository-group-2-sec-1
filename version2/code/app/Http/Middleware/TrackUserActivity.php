<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class TrackUserActivity
{

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $now = Carbon::now();
            if ($user->last_activity) {
                $last_activity = Carbon::parse($user->last_activity);
                $diff = $now->diffInMinutes($last_activity);
                if ($diff >= 1) {
                    User::where('id', $user->id)->update(['last_activity' => $now]);
                }
            } else {
                User::where('id', $user->id)->update(['last_activity' => $now]);
            }
            
        }
        return $next($request);
    }
}
