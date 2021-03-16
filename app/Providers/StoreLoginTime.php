<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StoreLoginTime
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event){
        
        $event->user->last_login = $event->user->this_login;
        
        $current_timestamp = Carbon::now('Europe/Ljubljana')->toDateTimeString();
        $event->user->this_login =  $current_timestamp;
        $event->user->save();
        
    }
}
