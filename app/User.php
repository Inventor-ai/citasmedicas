<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'identity_card', 'address', 'phone', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopePatients($query)
    {
        return $query->where('role', 'patient');
    }
    
    public function scopeDoctors($query)
    {
        return $query->where('role', 'doctor');
    }

    public function scopeUsers($query)
    {
        // return $query->where('role', 'like', '%');  // All Users
        return $query->where('role', 'admin');
    }

    // $user->specialties();
    public function specialties()
    {
      return $this->belongsToMany(Specialty::class)->withTimeStamps();
    }
}
