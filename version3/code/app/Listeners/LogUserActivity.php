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
        
       
        $ip = Request::header('X-Forwarded-For') ?? Request::ip(); // รองรับ Reverse Proxy
        $userAgent = Request::header('User-Agent');
        $log = Logs::create([
            'email' => $event->credentials['email'] ?? $event->credentials['username'] ?? 'Guest',
            'user_id' => null,
            'first_name' => null,
            'last_name' => null,
            'role' => null,
            'ip_address' => $ip,
            'browser' => $userAgent,
            'device' => $this->getDeviceType($userAgent),
            'activity_type' => 'Login Failed',
            'details' => 'User login failed',
        ]);
        Log::info("User " . ($event->credentials['email'] ?? $event->credentials['username'] ?? 'Guest') . " performed action: Login Failed (User login failed) from IP: {$ip}");
        
        $oneMinuteAgo = now()->subMinute();

        // ค้นหา record ใน critical_events ที่มีอยู่แล้ว
        $event = CriticalEvent::where('event_type', 'Login Failed')
            ->where('ip_address', $ip)
            ->where('event_time', '>=', $oneMinuteAgo)
            ->first();

        if ($event) {
            // ถ้าพบ record แล้ว ให้อัปเดต count เพิ่ม
            $event->increment('count');
            $event->update(['event_time' => now()]);

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
        if ($event->activity_type == 'Call Paper') {
            $ip = Request::header('X-Forwarded-For') ?? Request::ip(); // รองรับ Reverse Proxy
            $oneMinuteAgo = now()->subMinute();

            // ค้นหา Record ล่าสุดภายใน 1 นาที
            $existingRecord = CriticalEvent::where('event_type', 'Call Paper')
                ->where('ip_address', $ip)
                ->where('event_time', '>=', $oneMinuteAgo)
                ->orderBy('event_time', 'desc')
                ->first();

            if ($existingRecord) {
                // ถ้ามี Record ภายใน 1 นาที อัปเดต count +1
                $existingRecord->increment('count');
                $existingRecord->update(['event_time' => now()]);
            } else {
                // ถ้ายังไม่มี ให้สร้าง Record ใหม่
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
