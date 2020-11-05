<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
class ProductsController extends Controller
{
    public function addProduct(Request $request){
 
            $product = new Products();
            $product->product_name = $request->name;
            $product->product_status = 'available';
            $product->price = $request->price;
            $product->unit = $request->unit;
            // $product->image = $request->image;
            $name = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->store('public/images');

            $product->image = $path;
            $product->category_id = $request->cat_id;
            $product->save();
              
            return response()->json([
                "success" => true,
            ]);

        
    }
}
