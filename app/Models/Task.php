<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'status',
        'estimation',
        'effort',
        'start_date',
        'end_date',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'estimation' => 'integer',
        'effort' => 'integer',
    ];

    /**
     * Get the users that are assigned to the task.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
