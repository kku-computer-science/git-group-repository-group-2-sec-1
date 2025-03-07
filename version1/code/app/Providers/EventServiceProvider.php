<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use App\Listeners\LoginListener;
use App\Events\Login;
use App\Listeners\LogUserActivity;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \Illuminate\Auth\Events\Login::class => [
            LogUserActivity::class.'@login',
        ],
        \App\Events\Logout::class => [
            LogUserActivity::class.'@logout',
        ],
        \App\Events\UserAction::class => [
            LogUserActivity::class.'@userAction',
        ],



    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
