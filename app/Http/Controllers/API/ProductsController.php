<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;
use App\Models\ProductPictures;
use App\Models\ProductComment;
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
                $product->description = $request->description;
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
        $products = Products::with('category:category_name,id')->with('product_pictures')->get();
        // return response()->json([
        //     'success' => true,
        //     'data' => $products
        // ]);
        return response()->json($products);
    }

    public function getProdutcsByCat(Request $request){
   
        $products = Categories::where('id',$request->category_id)->with('products')->get();
        // return response()->json([
        //     'success' => true,
        //     'data' => $products
        // ]);
        return response()->json($products);
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
            $product->description = $request->description;
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

    public function getProductDetails(Request $request){

        // dd(\Auth::user());
        
        $id = $request->product_id;

        $product = Products::findOrFail($id)->with('category:category_name,id')->with('product_pictures')->get();

        return response()->json($product);
    }

    public function addPicturesToProducts(Request $request){
        DB::beginTransaction();

        try {
  
            $files = $request->file('image');
            $allowedfileExtension=['pdf','jpg','png'];

            foreach($files as $file){
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension,$allowedfileExtension);

                if($check){
                    foreach($request->image as $mediaFiles){
                        $path = $mediaFiles->store('public/images');
                        $name = $mediaFiles->getClientOriginalName();
              
                      
                        $pictures = new ProductPictures();
                        $pictures->product_id = $request->product_id;
                        $pictures->picture = $path;
                        $pictures->save();
                    }
                }else{
                    return response()->json('Failes');
                }
                DB::commit();
                return response()->json([
                    'status' => 'success'
                ]);
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                "status" => "fail",
                "message" => $th->getMessage()
            ], 400);
        }
    }

    public function addProductComment(Request $request){
        DB::beginTransaction();

        try {
            $user_id = \Auth::user()->id;
            $comment = new ProductComment;
            $comment->product_id = $request->product_id;
            $comment->user_id = $user_id;
            $comment->rating = $request->rating;
            $comment->comment = $request->comment;
            $comment->save();

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
