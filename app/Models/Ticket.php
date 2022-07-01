<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user_id', 'ticketNumber', 'category', 'closed', 'userTicket', 'gepettoResponse', 'checkGepettoResponse',
    ];
    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function Message()
    {
        return $this->hasMany('App\Models\Message');
    }
}
