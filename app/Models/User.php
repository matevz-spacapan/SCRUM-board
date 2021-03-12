<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'name',
        'surname',
        'email',
        'password',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects() {
        return $this->belongsToMany(Project::class)->withTimestamps();
    }

    /**
     * Returns true if the logged in user's account has ID equal to 1 (ADMIN account).
     *
     * @return bool
     */
    public function isAdmin(){
        $role = Auth::user()->getRoleNames();
        return $role[0]==="Administrator";
    }

    public function getLastLogin(){
        if($this->last_login != NULL){
            return 'Previous login: '.\Carbon\Carbon::parse($this->last_login)->setTimezone('Europe/Ljubljana')->format('H:i:s d. m. Y');
        }
        return 'First login';

    }

}
