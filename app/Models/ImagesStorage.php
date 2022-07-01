<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagesStorage extends Model
{
    protected $fillable = [
        'imageName', 'url',
    ];
}
