<?php

namespace App\Listeners;

use App\Events\CheckTaskStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReloadTaskList
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
    public function handle(CheckTaskStatus $event): void
    {
        \Artisan::call('task:check-status');
    }
}
