<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_role # 0: clan razvojne skupine, 1: skrbnik metodologije, 2: produktni vodja
 */

class Role extends Model
{
    use HasFactory;

    protected $attributes = [
        'user_role' => 0,
    ];

    public function projectuser()
    {
        return $this->belongsTo(ProjectUser:class);
    }
}
