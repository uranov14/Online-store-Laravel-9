<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;

class Product extends Model
{
    use HasFactory;

    public function section() {
        return $this->belongsTo('App\Models\Section', 'section_id')->select('id', 'name');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function brand() {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }

    public function attributes() {
        return $this->hasMany('App\Models\ProductsAttribute');
    }

    public function images() {
        return $this->hasMany('App\Models\ProductsImage');
    }

    public function vendor() {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id')->with('vendorbusinessdetails');
    }

    public static function getDiscountPrice($product_id) {
        //dd($product_id);
        $productDetails = Product::select('product_price', 'product_discount', 'category_id')->where('id', $product_id)->first();
        //dd($productDetails);
        $productDetails = json_decode(json_encode($productDetails), true);
        
        $categoryDiscount = Category::select('category_discount')->where('id', $productDetails['category_id'])->first();
        $categoryDiscount = json_decode(json_encode($categoryDiscount), true);

        if ($productDetails['product_discount'] > 0) {
            $discountedPrice = $productDetails['product_price'] - $productDetails['product_price'] / 100 * $productDetails['product_discount']; 
        } else if($categoryDiscount['category_discount'] > 0) {
            $discountedPrice = $productDetails['product_price'] - $productDetails['product_price'] / 100 * $categoryDiscount['category_discount'];
        } else {
            $discountedPrice = $productDetails['product_price'];
        }
        return $discountedPrice;
    }

    public static function getDiscountAttributePrice($product_id, $size) {
        $productPrice = ProductsAttribute::where(['product_id'=>$product_id, 'size'=>$size])->first()->toArray();

        $productDetails = Product::select('product_discount', 'category_id')->where('id', $product_id)->first();
        $productDetails = json_decode(json_encode($productDetails), true);

        $categoryDiscount = Category::select('category_discount')->where('id', $productDetails['category_id'])->first();
        $categoryDiscount = json_decode(json_encode($categoryDiscount), true);

        if ($productDetails['product_discount'] > 0) {
            $finalPrice = $productPrice['price'] - $productPrice['price'] / 100 * $productDetails['product_discount']; 
            $discount = $productPrice['price'] - $finalPrice;
        } else if($categoryDiscount['category_discount'] > 0) {
            $finalPrice = $productPrice['price'] - $productPrice['price'] / 100 * $categoryDiscount['category_discount'];
            $discount = $productPrice['price'] - $finalPrice;
        } else {
            $finalPrice = $productPrice['price'];
            $discount = 0;
        }

        return array('product_price'=>$productPrice['price'], 'final_price'=>$finalPrice, 'discount'=>$discount);
    }

    public static function isNewProduct($product_id) {
        //Get Last 3 Products
        $productIds = Product::select('id')->where('status', 1)->orderBy('id', 'Desc')->limit(3)->pluck('id');
        $productIds = json_decode(json_encode($productIds), true);

        if (in_array($product_id, $productIds)) {
            $isNewProd = true;
        } else {
            $isNewProd = false;
        }

        return $isNewProd;
    }

    public static function getProductImage($product_id) {
        $getProductImage = Product::select('product_image')->where('id', $product_id)->first()->toArray();
        return $getProductImage['product_image'];
    }

    public static function getProductStatus($product_id) {
        $getProductStatus = Product::select('status')->where('id', $product_id)->first();
        return $getProductStatus->status;
    }

    /* public static function getProductCategory($product_id) {
        $getProductCategory = Product::select('category_id')->where('id', $product_id)->first();
        return $getProductCategory->category_id;
    } */

    public static function deleteCartProduct($product_id) {
        Cart::where('product_id', $product_id)->delete();
    }
}
