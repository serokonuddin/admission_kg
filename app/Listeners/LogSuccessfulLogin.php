<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Auth\Events\Login;
use App\Models\LoginHistory;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event)
    {
        // dd(request()->header());
        LoginHistory::create([
            'user_id' => $event->user->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'logged_in_at' => now(),
            'mac_address' => PHP_OS_FAMILY === 'Windows' ? exec('getmac') : 'N/A',
        ]);
    }
}
