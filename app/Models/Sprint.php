<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sprint extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'speed',
        'start_date',
        'end_date'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
