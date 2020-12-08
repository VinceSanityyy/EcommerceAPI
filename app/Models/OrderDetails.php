<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
class OrderDetails extends Model
{
    use HasFactory;
    protected $table = 'order_details';
    protected $guarded = [];
    protected $appends = [
        'image_link'
    ];

    public function getImageLinkAttribute()
    {
        $image = Products::where('id',$this->product_id)->first();
        return $image->image_link;
    }
}
