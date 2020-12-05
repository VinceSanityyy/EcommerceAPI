<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderDetails;
use App\Models\Orders;
use App\Models\CartContent;
use Carbon\Carbon;

class OrdersController extends Controller
{
    public function checkOut(Request $request){
        $selectedProducts = json_decode($request->selectedProducts,true);

        $order = new Orders;
        $order->user_id = \Auth::user()->id;
        $totalPrice = 0;
        foreach ($selectedProducts as $key=>$val){
            $totalPrice +=  $val['product']['price'];
        }
        // dd($totalPrice);
        $order->price = $totalPrice;
        $order->date = Carbon::now()->toDateTimeString();
        $order->status = false;
        $order->save();

       
        // $orderDetails->product_id = $request->product_id;
      
       
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

        // \sleep(5000);
      
        $user = \Auth::user();
        $cartContent = CartContent::where('user_id',$user->id)->delete();
        return response()->json(array(
            "success" => true
        ));
    }


    public function getOrderListAdmin(){
        $orders = Orders::all();
        return response()->json($orders);
    }

    public function getOrderListCustomer(){
        $user = \Auth::user();
        $orders = Orders::where('user_id',$user->id)->get();
        return response()->json($orders);
    }

    public function getOrderListDetailsAdmin(Request $request){
        $details = Orders::where('id',$request->order_id)->with('orderDetails')->with('user')->get();
        return response()->json($details);
    }

    public function getOrderListDetailsCustomer(Request $request){
        $details = Orders::where('id',$request->order_id)->with('orderDetails')->with('user')->get();
        return response()->json($details);
    }

}
