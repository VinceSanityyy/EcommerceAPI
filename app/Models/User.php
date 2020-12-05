<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens; 
use App\Models\Cart;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'contact',
        'role_id',
        'isVerified',
        'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'image_link',
        'cart_count',
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

    public function getCartCountAttribute(){
        $user = \Auth::user();
        $cartCount = CartContent::where('user_id',$user->id)->count();
        return $cartCount;
    }

    public function userCartContent()
    {
        return $this->hasMany('App\Models\CartContent', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Comment\Orders');
    }


}
