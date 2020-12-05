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
        
        $order = new Orders;

        $order->user_id = \Auth::user()->id;
        $order->price = $request->total;
        $order->date = Carbon::now()->toDateTimeString();
        $order->status = false;
        $order->save();

        // echo($request->selectedProducts);
        // $orderDetails->product_id = $request->product_id;
      
        $selectedProducts = json_decode($request->selectedProducts,true);
        // dd($selectedProducts);
        foreach($selectedProducts as $value){
            $orderDetails = new OrderDetails;
            // dd($value);
            $orderDetails->order_id = $order->id;
            $orderDetails->product_id = $value['product_id'];
            $orderDetails->product_name = $value['product']['product_name'];
            $orderDetails->price = $value['product']['price'];
            $orderDetails->quantity = $value['quantity'];
            $orderDetails->unit = $value['product']['unit'];
            $orderDetails->category = $value['product']['category_id'];
            $orderDetails->save();
        }
        
        return response()->json(array(
            "success" => true
        ));
        
    }

}
