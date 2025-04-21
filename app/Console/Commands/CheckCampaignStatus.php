<?php

namespace App\Console\Commands;

use App\Models\EmailCampaign;
use Illuminate\Console\Command;

class CheckCampaignStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:check-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check campaign status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emailCampaigns = EmailCampaign::where('status', '!=', 3)->get();
        foreach ($emailCampaigns as $emailCampaign) {
        $now = now();
        if ($now < $emailCampaign->schedule_start) {
            $emailCampaign->status = 2;
        } elseif ($now > $emailCampaign->schedule_end) {
            $emailCampaign->status = 0;
        } else {
            $emailCampaign->status = 1;
        }
        $emailCampaign->save();
        }
    }
}
