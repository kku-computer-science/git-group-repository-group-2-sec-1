<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Models\Logs;

class LogErrorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (\Exception $e) {
            // บันทึก Log ลง Database
            Logs::create([
                'email' => auth()->user() ? auth()->user()->email : null, // Logged-in user's email (if available)
                'user_id' => auth()->user() ? auth()->user()->id : null, // User ID (if available)
                'first_name' => auth()->user() ? auth()->user()->first_name : null, // First name (if available)
                'last_name' => auth()->user() ? auth()->user()->last_name : null, // Last name (if available)
                'role' => auth()->user() ? auth()->user()->role : null, // Role (if available)
                'ip_address' => $request->ip(), // IP address
                'browser' => $request->header('User-Agent'), // Browser info from the user agent
                'device' => $request->header('Device'), // Device info (you may need to parse this manually)
                'activity_type' => 'error', // Activity type for error logs
                'details' => json_encode([ // Detailed error info
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                ]),
            ]);

            // บันทึก Log ลงไฟล์ `storage/logs/laravel.log`
            LaravelLog::error('Middleware Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
            ]);

            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}


