<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Carbon\Carbon;

class CheckTaskStatus extends Command
{
    protected $signature = 'task:check-status';
    protected $description = 'Check if the current time is between start_date and end_date of tasks and update status';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tasks = Task::all();
        $currentTime = Carbon::now();
        foreach ($tasks as $task) {
            $startDate = Carbon::parse($task->start_date);
            $endDate = Carbon::parse($task->end_date);

            if ($currentTime->between($startDate, $endDate)) {
                $task->status = '1'; // or any status you want to set
                $task->save();
            } elseif ($currentTime > $endDate) {
                $task->status = '0';
                $task->save();
            } elseif ($currentTime < $startDate) {
                $task->status = '2';
                $task->save();
            }
        }
        logger()->info('Task Status Checked');
    }
}
