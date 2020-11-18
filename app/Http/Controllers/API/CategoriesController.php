<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use DB;
class CategoriesController extends Controller
{
    public function addCategory(Request $request){

        DB::beginTransaction();
        try {
            $category = new Categories;
            $category->category_name = $request->name;
            $category->status = 'available';
            $category->save();
            DB::commit();
            return response()->json(array(
                'success' => true
            ));
        } catch (\Throwable $th) {
            DB::rollBack();
                return response()->json([
                    "status" => "fail",
                    "message" => $th->getMessage()
            ], 400);
        }
    }

    public function updateCategory(Request $request){
        DB::beginTransaction();
        // dd($request->all());
        try {
            $id = $request->category_id;
            $category = Categories::findOrFail($id);
            $category->category_name = $request->category_name;
            $category->status = $request->status;
            $category->save();

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
