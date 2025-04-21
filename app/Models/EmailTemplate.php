<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'name',
        'title',
        'content',
        'attachment',
        'description',
        'type'
    ];

    public function emailCampaigns()
    {
        // return $this->hasMany(EmailCampaign::class);
    }

}
