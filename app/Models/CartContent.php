<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartContent extends Model
{
    use HasFactory;
    protected $table = 'cart_contents';
    protected $guarded = [];

    public function cart()
    {
        return $this->belongsTo('App\Models\Cart', 'cart_id');
    }
}


