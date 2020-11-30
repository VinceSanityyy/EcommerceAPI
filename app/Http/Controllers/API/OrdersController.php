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
        $order->price = $request->price;
        $order->date = Carbon::now()->toDateTimeString();
        $order->status = false;
        $order->save();


        // $orderDetails->product_id = $request->product_id;
        $selectedProducts = json_decode($request->selectedProducts);

        foreach($selectedProducts as $key=>$value){
            $orderDetails = new OrderDetails;
            $orderDetails->order_id = $order->id;
            $orderDetails->product_name = $value->product_name;
            $orderDetails->price = $value->price;
            $orderDetails->quantity = $value->quantity;
            $orderDetails->unit = $value->unit;
            $orderDetails->category = $value->category;
            $orderDetals->save();
        }
        

    }

}
