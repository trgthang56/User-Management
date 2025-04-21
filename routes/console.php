<?php

use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule::command('app:send-email')->everyTwoMinutes();

Schedule::command('task:check-status')->hourly();
Schedule::command('campaign:check-status')->hourly();
Schedule::command('user:check-birth')->daily();
Schedule::command('task:check-date')->daily();

// Schedule::command('email:send-campaign')->everyMinute();

// $schedule->call(function () {
//     event(new \App\Events\SendEmail());
// })->hourly();
