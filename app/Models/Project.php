<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name', //unique

    ];

    public function users() {
        return $this->belongsToMany('App\User')->withPivot('role')->withTimestamps();
    }

    public function sprints() {
        return $this->hasMany(Sprint::class);
    }
}
