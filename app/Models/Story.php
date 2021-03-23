<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    public $timestamps = true;

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

    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
