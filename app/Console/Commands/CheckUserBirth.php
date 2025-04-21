<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
use App\Events\SendEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckUserBirth extends Command implements ShouldQueue
{
    use InteractsWithQueue;
    protected $signature = 'user:check-birth';
    protected $description = 'Check user birth dates and perform actions if necessary';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = User::orderBy('id', 'asc')->get();
        $today = Carbon::now()->format('m-d');
        foreach ($users as $user) {
            if ($user->birthday) {
                $birthDate = Carbon::parse($user->birthday)->format('m-d');
            } else continue;
            if ($birthDate === $today) {
                // Perform action, e.g., send birthday email
                $this->info("Happy Birthday, {$user->name}!");
                event(new SendEmail($user, 2));
            }
        }
    }
}
