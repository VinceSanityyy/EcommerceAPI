<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartContent;
use DB;

class CartController extends Controller
{
    public function addToCart(Request $request){

        $cartIsExist = Cart::where('user_id',\Auth::user()->id)->exists();

        if($cartIsExist){
            $cart =  Cart::where('user_id',\Auth::user()->id)->first();
        }else{
            $cart = new Cart;
            $cart->user_id = \Auth::user()->id;
            $cart->save();
        }

        $productIsExist = CartContent::where('user_id',\Auth::user()->id)->where('product_id',$request->product_id)->exists();

        if($productIsExist){
            $cartContent = CartContent::where('user_id',\Auth::user()->id)->where('product_id',$request->product_id)->first();
            $cartContent->quantity = ($cartContent->quantity + $request->quantity);
            $cartContent->save();
            
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            $cartContent = new CartContent;
            $cartContent->cart_id = $cart->id;
            $cartContent->product_id = $request->product_id;
            $cartContent->quantity = $request->quantity;
            $cartContent->user_id = \Auth::user()->id;
            $cartContent->save();

            return response()->json([
                'status' => 'success'
            ]);
        }
    }

    public function updateCart(Request $request){
        $id = $request->cartContentId;
        $cartContent = CartContent::find($id);
        $cartContent->quantity = $request->quantity;
        $cartContent->save();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function clearCart(Request $request){
        $id = $request->cart_id;
        $cartContent = CartContent::where('cart_id',$id)->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function getCartContent(){
        $user = \Auth::user();
        $content = CartContent::where('user_id',$user->id)->with('product')->get();

        return response()->json($content);
    }
}
