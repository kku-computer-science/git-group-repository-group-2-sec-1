<?php 

namespace App\Listeners;

use Illuminate\Auth\Events as AuthEvents;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class LogUserActivity
{

    public function login(AuthEvents\Login $event)
    {
        $ip = request()->getClientIp();
        $this->info($event, "User {$event->user->email} logged in from {$ip}");   
    }
    public function logout(\App\Events\Logout $event)
    {
        $ip = request()->getClientIp();
        $this->info($event, "User {$event->user->email} logged in from {$ip}");
    }
    public function userAction(\App\Events\UserAction $event)
    {
        $this->info($event, "User {$event->user->email} {$event->activity_type} {$event->details}");
    }


    protected function info(object $event,string $message,array $context = []): void
    {
        $class = get_class($event);
        Log::info("{$class}: {$message}",$context);
    }
}