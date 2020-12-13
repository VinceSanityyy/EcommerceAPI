<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatDetails extends Model
{
    use HasFactory;

    public function chatBody()
    {
        return $this->belongsTo('App\Models\Chat');
    }
}
