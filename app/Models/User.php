<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, Billable;
    // use HasFactory
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role', 'firstname', 'lastname', 'company', 'phoneNumber', 'pseudonym', 'email', 'password'
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

    // Eloquent: Relationships
    public function order()
    {
        return $this->hasMany('App\Models\Order');
    }
    public function estimate()
    {
        return $this->hasMany('App\Models\Estimate');
    }
    public function file()
    {
        return $this->hasMany('App\Models\File');
    }
}
