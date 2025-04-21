<?php

namespace App\Listeners;

use App\Events\SendEmail;
use App\Mail\EmailByTemplate;
use App\Models\EmailCampaign;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;

class EmailTypeOne
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
    public function handle(SendEmail $event): void
    {
        if ($event->type == 1) {
            $user = $event->user;
            $type = $event->type;
            $emailCampaign = EmailCampaign::where('status', 1)->where('type', $type)->get();
            foreach ($emailCampaign as $campaign) {
                Mail::to($user->email)->send(new EmailByTemplate($campaign->template, $user));
            }
        }
    }
}
