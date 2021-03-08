<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectUser extends Pivot
{
    
    public function projects() {
        return $this->belongsToMany(Project::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function role() {
        retunr $this->hasOne(Role::class);
    }


    
}