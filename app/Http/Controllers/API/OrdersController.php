<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderDetails;
use App\Models\Orders;
use Carbon\Carbon;

class OrdersController extends Controller
{
    public function checkOut(Request $request){
        dd($request->selectedProducts);
        $order = new Orders;

        $order->user_id = \Auth::user()->id;
        $order->price = null;
        $order->date = Carbon::now()->toDateTimeString();
        $order->status = false;
        $order->save();


        // $orderDetails->product_id = $request->product_id;
      
        $selectedProducts = json_decode($request->selectedProducts,true);
        
        foreach($selectedProducts as $value){
            $orderDetails = new OrderDetails;
            // dd($value['price']);
            $orderDetails->order_id = $order->id;
            $orderDetails->product_id = $value['product_id'];
            $orderDetails->product_name = $value['product_name'];
            $orderDetails->price = $value['price'];
            $orderDetails->quantity = $value['quantity'];
            $orderDetails->unit = $value['unit'];
            $orderDetails->category = $value['category'];
            $orderDetails->save();
        }
        
        return response()->json(array(
            "success" => true
        ));
        
    }

}
