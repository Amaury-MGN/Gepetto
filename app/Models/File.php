<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    // Eloquent: Relationships
    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function estimate()
    {
        return $this->belongsTo('App\Models\Estimate');
    }
}
