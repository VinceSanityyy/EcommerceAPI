<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;
use DB;
class ProductsController extends Controller
{
    public function addProduct(Request $request){

        DB::beginTransaction();
            try {

                $product = new Products();
                $product->product_name = $request->name;
                $product->product_status = 'available';
                $product->price = $request->price;
                $product->unit = $request->unit;
                $name = $request->file('image')->getClientOriginalName();
                $path = $request->file('image')->store('public/images');

                $product->image = $path;
                $product->category_id = $request->category_id;
                $product->save();

                DB::commit();
                return response()->json([
                    'status' => 'success'
                ]);

            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    "status" => "fail",
                    "message" => $th->getMessage()
                ], 400);
            }
        
    }

    public function getProducts(){
        $products = Products::with('category:category_name,id')->get();
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

    public function updateProduct(Request $request){
     
        DB::beginTransaction();

        try {
            $id = $request->product_id;
            $product =  Products::findOrFail($id);
            $product->product_name = $request->name;
            $product->product_status = $request->status;
            $product->price = $request->price;
            $product->unit = $request->unit;
            $product->category_id = $request->category_id;

            $name = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->store('public/images');

            $product->image = $path;
            $product->save();

            DB::commit();
            return response()->json([
                'status' => 'success'
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                "status" => "fail",
                "message" => $th->getMessage()
            ], 400);
        }
    }
}
