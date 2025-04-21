<?php

namespace App\Console\Commands;

use App\Events\CheckTaskStatus;
use App\Events\SendEmail;
use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailByTemplateContent;

class CheckTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:check-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check task date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        event(new CheckTaskStatus());
        $tasks = Task::where('status', 1)->get();
        foreach ($tasks as $task) {
            $userIdsString = $task->user_id;
            $userIdsArray = explode(',', trim($userIdsString, '()'));
            foreach ($userIdsArray as $userId) {
                $userId = (int) $userId;
                $user = User::find($userId);
                // dd($user);
                if ($user) {
                    event(new SendEmail($user, 1));
                }
            }
        }
    }
}
