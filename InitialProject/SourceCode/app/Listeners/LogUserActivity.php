<?php

namespace App\Listeners;

use App\Models\Logs;
use App\Events\UserAction;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use App\Models\CriticalEvent;
class LogUserActivity
{
    /**
     * Handle user login event.
     */
    public function login(Login $event)
    {
        $this->logActivity($event->user, 'Login', 'User logged in');
    }
    public function loginFailed(Failed $event)
    {
        $this->logActivity(null, 'Login Failed', 'User login failed');
        
        $ip = Request::ip();
        $oneMinuteAgo = now()->subMinute();

        // ค้นหา record ใน critical_events ที่มีอยู่แล้ว
        $event = CriticalEvent::where('event_type', 'Login Failed')
            ->where('ip_address', $ip)
            ->where('event_time', '>=', $oneMinuteAgo)
            ->first();

        if ($event) {
            // ถ้าพบ record แล้ว ให้อัปเดต count เพิ่ม
            $event->increment('count');

            if ($event->count >= 5) {
                Log::warning("IP: {$ip} พบความพยายาม Login Failed เกิน 5 ครั้งใน 1 นาที!");
            }
        } else {
            // ถ้ายังไม่มี record ใน 1 นาที ให้สร้างใหม่
            CriticalEvent::create([
                'event_type' => 'Login Failed',
                'ip_address' => $ip,
                'count' => 1,
                'event_time' => now(),
            ]);
        }
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
        if($event->activity_type == 'Call Paper'){
            $ip = Request::ip();
            $oneMinuteAgo = now()->subMinute();
    
            // ค้นหา record ใน critical_events ที่มีอยู่แล้ว
            $event = CriticalEvent::where('event_type', 'Call Paper')
                ->where('ip_address', $ip)
                ->where('event_time', '>=', $oneMinuteAgo)
                ->first();
    
            if ($event) {
                // ถ้าพบ record แล้ว ให้อัปเดต count เพิ่ม
                $event->increment('count');
    
                if ($event->count >= 5) {
                    Log::warning("IP: {$ip} พบความพยายาม Call Paper เกิน 5 ครั้งใน 1 นาที!");
                }
            } else {
                // ถ้ายังไม่มี record ใน 1 นาที ให้สร้างใหม่
                CriticalEvent::create([
                    'event_type' => 'Call Paper',
                    'ip_address' => $ip,
                    'count' => 1,
                    'event_time' => now(),
                ]);
            }
        }
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
        Log::info("User " . ($user->email ?? 'Guest') . " performed action: {$activityType} ({$details}) from IP: {$ip}");

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
