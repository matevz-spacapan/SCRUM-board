<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Story extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'tests',
        'priority',
        'business_value',
        'project_id',
        'hash',
        'time_estimate',
        'to_sprint',
        'comment',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function amount_worked()
    {
        $tasks = Task::query()
            ->withSum('works', 'amount_min')
            ->where('story_id', $this->id)
            ->get();

        $amount_worked = 0;
        foreach ($tasks as $taskInDB) {
            $work = $taskInDB->works_sum_amount_min;
            if ($work) {
                $amount_worked += $work;
            }
        }
        return round($amount_worked / 60, 2);
    }
}
