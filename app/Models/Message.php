<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        //
    ];
    public function Ticket()
    {
        return $this->belongsTo('App\Models\Ticket');
    }
}
