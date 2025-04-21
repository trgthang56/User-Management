<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailCampaign extends Model
{
    protected $fillable = [
        'name',
        'task_id',
        'description',
        'template_id',
        'status',
        'schedule_start',
        'schedule_end',
        'type',
        'recipients',
    ];

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }
}
