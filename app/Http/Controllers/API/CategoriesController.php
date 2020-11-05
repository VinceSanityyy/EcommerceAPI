<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
class CategoriesController extends Controller
{
    public function addCategory(Request $request){

        $category = new Categories;
        $category->category_name = $request->name;
        $category->status = 'available';
        $category->save();

        return response()->json(array(
            'success' => true
        ));
    }
}
