<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstimateAdmin extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'estimateAdminFile', 'estimateAdminPrice', 'estimateAdminContents',
    ];
    protected $guarded = [];

    // Eloquent: Relationships
    public function Estimate()
    {
        return $this->belongsTo('App\Models\Estimate');
    }
    public function file()
    {
        return $this->hasMany('App\Models\File');
    }
}
