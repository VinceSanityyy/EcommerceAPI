<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $guarded = [];

    protected $appends = [
        'status_label'
    ];

    public function getStatusLabelAttribute(){
        if($this->status == OrderStatus::PENDING){
            return 'Pending';
        }else{
            return 'Completed';
        }
    }


    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function orderDetails()
    {
        return $this->hasMany('App\Models\OrderDetails','order_id');
    }
}
