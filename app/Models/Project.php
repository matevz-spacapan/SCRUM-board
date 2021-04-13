<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name', //unique
        'documentation'
    ];

    public function users() {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function stories(){
        return $this->hasMany(Story::class);
    }

    public function wall_posts(){
        return $this->hasMany(Wall::class);
    }

    public function sprints() {
        return $this->hasMany(Sprint::class);
    }
}
