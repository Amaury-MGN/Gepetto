<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'orderNumber', 'orderName', 'orderItems', 'orderContents', 'orderProgress', 'orderAdminFileName', 'orderAdminFilePath', 'orderInvoice', 'orderPrice',
    ];

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
}
