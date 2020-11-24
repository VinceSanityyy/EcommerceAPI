<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPictures extends Model
{
    use HasFactory;
    
    protected $table = 'product_pictures';
    protected $guarded = [];
    protected $appends = [
        'image_link'
    ];

    public function pictures()
    {
        return $this->belongsTo('App\Models\Products', 'product_id');
    }

    public function getImageLinkAttribute()
    {

        if (!empty($this->picture)) {

            // explode by /
            $explode_path = explode('/', $this->picture);
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
}
