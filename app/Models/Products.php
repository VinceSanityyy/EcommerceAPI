<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'products';
    protected $appends = [
        'image_link',
    ];
    

    public function getImageLinkAttribute()
    {

        if (!empty($this->image)) {

            // explode by /
            $explode_path = explode('/', $this->image);
            // removed first value in array wich is the public of the path
            unset($explode_path[0]);
            // return back to his format
            $implode_path = implode('/', $explode_path);
            $photo = url('storage/' . $implode_path);
        } else {
            // $photo = $this->is_bundle == 1 ? "/img/bundle.png" : "/img/no-product-image.png";
            $photo = "";
        }

        return $photo;
    }

  
    

    public function category()
    {
        return $this->belongsTo('App\Models\Categories');
    }

    public function product_pictures()
    {
        return $this->hasMany('App\Models\ProductPictures','product_id');
    }

    public function product_comments()
    {
        return $this->hasMany('App\Models\ProductComment','product_id');
    }
}
