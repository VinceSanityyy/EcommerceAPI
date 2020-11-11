<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;
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
            $product->category_id = $request->category_id;
            $product->save();
              
            return response()->json([
                "success" => true,
            ]);
    }

    public function getProducts(){
        $products = Products::with('category:category_name,id')->get();
        // dd($products);
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function getProdutcsByCat(Request $request){
   
        $products = Categories::where('id',$request->category_id)->with('products')->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }
}
