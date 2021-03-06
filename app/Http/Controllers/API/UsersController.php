<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
class UsersController extends Controller
{
    public function register(Request $request){

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = \Hash::make($request->password);
        $user->address = $request->address;
        $user->contact = $request->contact;

        $name = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->store('public/images');
        $user->image = $path;

        $user->isVerified = 0;
        $user->role_id = 3;

        $user->save();

        return response()->json([
            "success" => true,
        ]);
    }

    public function getUsers(){
        $users = User::all();
        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    public function updateUser(Request $request){
        DB::beginTransaction();
        try{
            $id = $request->user_id;
            $user = User::findOrFail($id);
            $user->isVerified = $request->isVerified;
            $user->save();
            DB::commit();
            return response()->json([
                'status' => 'success'
            ]);
        } catch (\Throwable $th){
            DB::rollBack();
            return response()->json([
                "status" => "fail",
                "message" => $th->getMessage()
            ], 400);
        }
    }
}
