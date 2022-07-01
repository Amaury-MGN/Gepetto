<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'estimateName', 'estimateContents', 'estimateUserFile', 'estimateItemNumber'
    ];

    // Eloquent: Relationships
    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function file()
    {
        return $this->hasMany('App\Models\File');
    }
    public function estimateAdmin()
    {
        return $this->hasOne('App\Models\EstimateAdmin');
    }
}
