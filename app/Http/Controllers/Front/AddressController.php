<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryAddress;
use App\Models\Country;
use Auth;
use Validator;

class AddressController extends Controller
{
    public function getDeliveryAddress(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            $address = DeliveryAddress::where('id', $data['addressid'])->first()->toArray();

            return response()->json([
                'address'=>$address
            ]);
        }
    }

    public function saveDeliveryAddress(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $validator = Validator::make($request->all(), [
                'delivery_name' => 'required|string|max:100',
                'delivery_address' => 'required|string|max:100',
                'delivery_city' => 'required|string|max:100',
                'delivery_state' => 'required|string|max:100',
                'delivery_country' => 'required|string|max:100',
                'delivery_pincode' => 'required',
                'delivery_mobile' => 'required|numeric|digits:10',
            ]);

            if ($validator->passes()) {
                $address = array();
                $address['user_id'] = Auth::user()->id;
                $address['name'] = $data['delivery_name'];
                $address['address'] = $data['delivery_address'];
                $address['city'] = $data['delivery_city'];
                $address['state'] = $data['delivery_state'];
                $address['country'] = $data['delivery_country'];
                $address['pincode'] = $data['delivery_pincode'];
                $address['mobile'] = $data['delivery_mobile'];

                if (!empty($data['delivery_id'])) {
                    # Edit Delivery Address
                    DeliveryAddress::where('id', $data['delivery_id'])->update($address);
                } else {
                    # Add Delivery Address
                    $address['status'] = 1;
                    DeliveryAddress::create($address);
                }
                $deliveryAddress = DeliveryAddress::deliveryAddress();
                $countries = Country::where('status', 1)->get()->toArray();

                return response()->json([
                    'view'=>(String)View::make('front.products.delivery_addresses')->with(compact('deliveryAddress', 'countries'))
                ]);
            } else {
                return response()->json(['type'=>'error', 'errors'=>$validator->messages()]);
            }

            
        }
    }

    public function removeDeliveryAddress(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            DeliveryAddress::where('id', $data['addressid'])->delete();
            //Show after delete and update
            $deliveryAddress = DeliveryAddress::deliveryAddress();
            $countries = Country::where('status', 1)->get()->toArray();

            return response()->json([
                'view'=>(String)View::make('front.products.delivery_addresses')->with(compact('deliveryAddress', 'countries'))
            ]);
        } 
    }
}
