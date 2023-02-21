<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function section() {
        return $this->belongsTo('App\Models\Section', 'section_id')->select('id', 'name');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category', 'category_id')->select('id', 'category_name');
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

    public static function getDiscountPrice($product_id) {
        $productDetails = Product::select('product_price', 'product_discount', 'category_id')->where('id', $product_id)->first();
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
}
