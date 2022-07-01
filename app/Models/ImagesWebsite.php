<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagesWebsite extends Model
{
    protected $fillable = [
        'webPage', 'firstImage', 'secondImage', 'thirdImage', 'fourthImage',
    ];
}
