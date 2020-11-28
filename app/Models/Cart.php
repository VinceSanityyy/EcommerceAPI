<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $guarded = [];

    public function cart_content()
    {
        return $this->hasMany('App\Models\CartContent', 'cart_id');
    }
}
