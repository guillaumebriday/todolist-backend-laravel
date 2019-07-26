<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'due_at',
        'is_completed',
        'user_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'due_at' => 'datetime',
        'is_completed' => 'boolean'
    ];

    /**
     * Set the task's due_at date in UTC.
     */
    public function setDueAtAttribute(?string $carbon): void
    {
        $this->attributes['due_at'] = null;

        if (filled($carbon)) {
            $this->attributes['due_at'] = Carbon::parse($carbon)->setTimezone("UTC");
        }
    }

    /**
     * Return the task's author
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope a query to only include completed tasks.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->whereIsCompleted(true);
    }
}
