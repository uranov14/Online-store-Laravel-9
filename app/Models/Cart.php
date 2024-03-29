<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;
use Auth;

class Cart extends Model
{
    use HasFactory;

    public static function getCartItems() {
        if (Auth::check()) {
            //User is Logged in / pick auth id of the User
            $user_id = Auth::user()->id;
            $getCartItems = Cart::with(['product'=>function($query) {
                $query->select('id', 'category_id', 'product_name', 'product_code', 'product_color', 'product_price', 'product_image', 'product_weight');
            }])->orderBy('id','Desc')->where('user_id', $user_id)->get()->toArray();
        } else {
            //User is not Logged in / pick session id of the User
            $getCartItems = Cart::with(['product'=>function($query) {
                $query->select('id', 'category_id', 'product_name', 'product_code', 'product_color', 'product_price', 'product_image', 'product_weight');
            }])->orderBy('id','Desc')->where('session_id', Session::get('session_id'))->get()->toArray();
        }

        return $getCartItems;
    }

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
}
