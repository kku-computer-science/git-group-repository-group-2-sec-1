<?php

namespace App\Listeners;

use App\Models\Logs;
use App\Events\UserAction;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogUserActivity
{
    /**
     * Handle user login event.
     */
    public function login(Login $event)
    {
        $this->logActivity($event->user, 'Login', 'User logged in');
    }

    /**
     * Handle user logout event.
     */
    public function logout(\App\Events\Logout $event)
    {
        $this->logActivity($event->user, 'Logout', 'User logged out');
    }

    /**
     * Handle custom user action event.
     */
    public function userAction(UserAction $event)
    {
        $this->logActivity($event->user, $event->activity_type, $event->details);
    }

    /**
     * Store activity log in the database and log file.
     */
    protected function logActivity($user, string $activityType, string $details): void
    {
        $ip = Request::ip();
        $userAgent = Request::header('User-Agent');
        
        $log = Logs::create([
            'email' => $user->email ?? 'Guest',
            'user_id' => $user->id ?? null,
            'first_name' => $user->first_name ?? null,
            'last_name' => $user->last_name ?? null,
            'role' => $user->role ?? null,
            'ip_address' => $ip,
            'browser' => $userAgent,
            'device' => $this->getDeviceType($userAgent),
            'activity_type' => $activityType,
            'details' => $details,
        ]);
        Log::info("User {$user->email} performed action: {$activityType} ({$details}) from IP: {$ip}");
    }

    /**
     * Determine the device type from user agent.
     */
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
