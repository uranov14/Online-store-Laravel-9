<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Auth;

class OrderController extends Controller
{
    public function orders($id=null) {
        if (empty($id)) {
            $orders = Order::with('orders_products')->where('user_id', Auth::user()->id)->OrderBy('id', 'Desc')->get()->toArray();
            //dd($orders);
            return view('front.orders.orders')->with(compact('orders'));
        } else {
            $orderDetails = Order::with('orders_products')->where('id', $id)->first()->toArray();
            //dd($orderDetails);
            return view('front.orders.order_detail')->with(compact('orderDetails'));
        }
    }
}
