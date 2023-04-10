<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderItemStatus;
use App\Models\OrderProduct;
use App\Models\User;
use Session;
use Auth;

class OrderController extends Controller
{
    public function orders() {
        Session::put('page', 'orders');
        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        if ($adminType == "vendor") {
            $vendorStatus = Auth::guard('admin')->user()->status;
            if ($vendorStatus == 0) {
                return redirect('admin/update-vendor-details/personal')->with('error_message', "Your Vendor Account is not approved yet. Please make sure to fill your valid personal, business and bank details");
            }
            $orders = Order::with(['orders_products'=>function($query)use($vendor_id) {
                $query->where('vendor_id', $vendor_id);
            }])->OrderBy('id', 'Desc')->get()->toArray();
        } else {
            $orders = Order::with('orders_products')->OrderBy('id', 'Desc')->get()->toArray();
        }
        
        return view('admin.orders.orders')->with(compact('orders'));
    }

    public function orderDetails($id) {
        Session::put('page', 'orders');
        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        if ($adminType == "vendor") {
            $vendorStatus = Auth::guard('admin')->user()->status;
            if ($vendorStatus == 0) {
                return redirect('admin/update-vendor-details/personal')->with('error_message', "Your Vendor Account is not approved yet. Please make sure to fill your valid personal, business and bank details");
            }
            $orderDetails = Order::with(['orders_products'=>function($query)use($vendor_id) {
                $query->where('vendor_id', $vendor_id);
            }])->first()->toArray();
        } else {
            $orderDetails = Order::with('orders_products')->where('id', $id)->first()->toArray();
        }
        //echo "<pre>"; print_r($orderDetails['orders_products']); die;
        $userDetails = User::where('id', $orderDetails['user_id'])->first()->toArray();
        $orderStatuses = OrderStatus::where('status', 1)->get()->toArray();
        $orderItemStatuses = OrderItemStatus::where('status', 1)->get()->toArray();
        //echo "<pre>"; print_r($orderItemStatuses); die;

        return view('admin.orders.order_details')->with(compact('orderDetails', 'userDetails', 'orderStatuses', 'orderItemStatuses'));
    }

    public function updateOrderStatus(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            //Update orders table
            Order::where('id', $data['order_id'])->update(['order_status'=>$data['order_status']]);

            //Get Delivery Details
            $deliveryDetails = Order::select('name', 'email', 'mobile')->where('id', $data['order_id'])->first()->toArray();

            $orderDetails = Order::with('orders_products')->where('id', $data['order_id'])->first()->toArray();

            //Send Order Status Update Email
            $email = $deliveryDetails['email'];
            $messageData = [
                'email' => $email,
                'name' => $deliveryDetails['name'],
                'order_id' => $data['order_id'],
                'orderDetails' => $orderDetails,
                'order_status' => $data['order_status'],
            ];
            Mail::send('emails.order_status', $messageData, function ($message)use($email) {
                $message->to($email)->subject('Order Status Updated!');
            });

            //Send Order Status Update Sms
            /* $message = "Dear Customer, your order #".$data['order_id']."status has been updated to".$data['order_status']."placed with Our Store";
            $mobile = $deliveryDetails['mobile'];

            Sms::sendSms($message, $mobile); */

            return redirect()->back()->with('success_message', "Order Status has been updated successfully!");
        }
    }

    public function updateOrderItemStatus(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            //Update order_products table
            OrderProduct::where('id', $data['order_item_id'])->update(['item_status'=>$data['order_item_status']]);

            $vendor_id = Auth::guard('admin')->user()->vendor_id;

            $getOrderId = OrderProduct::select('order_id')->where('id', $data['order_item_id'])->first()->toArray();
            
            //Get Delivery Details
            $deliveryDetails = Order::select('name', 'email', 'mobile')->where('id', $getOrderId['order_id'])->first()->toArray();

            $orderDetails = Order::with(['orders_products'=>function($query)use($data) {
                $query->where('id', $data['order_item_id']);
            }])->where('id', $getOrderId['order_id'])->first()->toArray();
            //echo "<pre>"; print_r($orderDetails['orders_products']); die;

            //Send Order Status Update Email
            $email = $deliveryDetails['email'];
            $messageData = [
                'email' => $email,
                'name' => $deliveryDetails['name'],
                'order_id' => $getOrderId['order_id'],
                'orderDetails' => $orderDetails,
                'order_status' => $data['order_item_status'],
            ];
            Mail::send('emails.order_status', $messageData, function ($message)use($email) {
                $message->to($email)->subject('Order Item Status Updated!');
            });

            //Send Order Status Update Sms
            /* $message = "Dear Customer, your order #".$order_id."status has been updated to".$data['order_status']."placed with Our Store";
            $mobile = $deliveryDetails['mobile'];

            Sms::sendSms($message, $mobile); */

            return redirect()->back()->with('success_message', "Order Item Status has been updated successfully!");
        }
    }
}
