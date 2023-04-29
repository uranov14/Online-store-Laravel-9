<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\Order;
use Auth;
use Session;
use Omnipay\Omnipay;

class PaypalController extends Controller
{
    private $gateway;

    public function __construct() {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true);
    }

    public function paypal() {
        if (Session::has('order_id')) {
            //Empty the Cart
            Cart::where('user_id', Auth::user()->id)->delete();
            Session::forget('couponCode'); 
            Session::forget('couponAmount');
            return view('front.paypal.paypal');
        } else {
            return redirect('cart');
        }
    }

    public function pay(Request $request) {
        try {
            $paypal_amount = round(Session::get('grand_total') / 36.95, 2);
            $response = $this->gateway->purchase(array(
                'amount' => $paypal_amount,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => url('success'),
                'cancelUrl' => url('error')
            ))->send();

            if ($response->isRedirect()) {
                $response->redirect();
            } else {
                return $response->getMessage();
            }

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function success(Request $request) {
        if (!Session::has('order_id')) {
            return redirect('cart');
        }
        
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payerId' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId')
            ));

            $response = $transaction->send();

            if ($response->isSuccessful()) {
                $arr = $response->getData();
                $payment = new Payment;
                $payment->order_id = Session::get('order_id');
                $payment->user_id = Auth::user()->id;
                $payment->payment_id = $arr['id'];
                $payment->payer_id = $arr['payer']['payer_info']['payer_id'];
                $payment->payer_email = $arr['payer']['payer_info']['email'];
                $payment->amount = $arr['transactions'][0]['amount']['total'];
                $payment->currency = env('PAYPAL_CURRENCY');
                $payment->payment_status = $arr['state'];
                $payment->save();

                //Update the Order
                $order_id = Session::get('order_id');
                //Update Order Status to Paid
                Order::where('id', $order_id)->update(['order_status' => "Paid"]);

                //Send Order SMS
                /* $message = "Dear Customer, your order ".$order_id."has been successfully placed! We will intimate you once your order is shipped.";
                $mobile = Auth::user()->mobile;

                Sms::sendSms($message, $mobile); */

                $orderDetails = Order::with('orders_products')->where('id', $order_id)->first()->toArray();

                //Send Order Email
                $email = Auth::user()->email;
                $messageData = [
                    'email' => $email,
                    'name' => Auth::user()->name,
                    'order_id' => $order_id,
                    'orderDetails' => $orderDetails
                ];
                Mail::send('emails.order', $messageData, function ($message)use($email) {
                    $message->to($email)->subject('Order Placed - Your Shop!');
                });

                //Reduce Stock
                foreach ($orderDetails['orders_products'] as $key => $order) {
                    $getProductStock = ProductsAttribute::isStockAvailable($order['product_id'], $order['product_size']);

                    $newStock = $getProductStock - $order['product_qty'];

                    ProductsAttribute::where(['product_id'=>$order['product_id'], 'size'=>$order['product_size']])->update(['stock'=>$newStock]);
                }

                //Empty the Cart
                Cart::where('user_id', Auth::user()->id)->delete();

                return view('front.paypal.success');
                //return "Payment is Successful! Your transaction is ".$arr['id'];
            } else {
                return $response->getMessage();
            }
        } else {
            return "Payment Declined!";
        }
    }

    public function error() {
        //return "User declined the payment!";
        return view('front.paypal.fail');
    }
}
