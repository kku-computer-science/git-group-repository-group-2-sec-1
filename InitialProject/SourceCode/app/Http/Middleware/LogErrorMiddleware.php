<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;

class LogErrorMiddleware
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
    public function terminate($request, $response)
    {
        // Check if the status code is an error (4xx or 5xx)
        if ($response->getStatusCode() >= 400) {
            $user = Auth::check() ? Auth::user() : null;
            $ip = Request::ip();
            $userAgent = Request::header('User-Agent');
            $logData = [
                'email' => $user->email ?? 'Guest',
                'user_id' => $user->id ?? null,
                'first_name' => $user->first_name ?? null,
                'last_name' => $user->last_name ?? null,
                'role' => $user->role ?? null,
                'ip_address' => $ip,
                'browser' => $userAgent,
                'device' => $this->getDeviceType($userAgent),
                'activity_type' => "Error",
                'details' => json_encode([
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'status' => $response->getStatusCode(),
                ]),
            ];
            Logs::create($logData);
        }
    }
    protected function getDeviceType(string $userAgent): string
    {
        if (stripos($userAgent, 'mobile') !== false) {
            return 'Mobile';
        } elseif (stripos($userAgent, 'tablet') !== false) {
            return 'Tablet';
        } else {
            return 'Desktop';
        }
    }

}