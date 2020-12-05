<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function orderDetails()
    {
        return $this->hasMany('App\Models\OrderDetails','order_id');
    }
}
