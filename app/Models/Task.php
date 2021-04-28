<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'time_estimate',
        'accepted',
        'story_id',
        'user_id'
    ];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function works()
    {
        return $this->hasMany(Work::class);
    }

    public function is_worked_on()
    {
        return User::query()
            ->where('working_on', $this->id)
            ->first();
    }

    public function most_recent_time_estimate_min()
    {
        $most_recent_work = Work::query()
            ->where('task_id', $this->id)
            ->orderBy('day', 'desc')
            ->first();
        if ($most_recent_work) {
            return $most_recent_work->time_estimate_min;
        } else {
            return $this->time_estimate * 60;
        }
    }
}
