<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;

class IndexController extends Controller
{
    public function index() {
        // Session::put('page', "products");
        $sliderBanners = Banner::where(['type'=>"Slider", 'status'=>1])->get()->toArray();
        $fixBanners = Banner::where(['type'=>"Fix", 'status'=>1])->get()->toArray();
        //dd($fixBanners); 
        $newProducts = Product::orderBy('id', 'Desc')->where('status', 1)->limit(3)->get()->toArray();       
        $bestSellers = Product::where(['is_bestseller'=>'Yes', 'status'=>1])->inRandomOrder()->get()->toArray();
        //dd($bestSellers);
        $discountedProducts = Product::where('product_discount', '>', 0)->where('status', 1)->limit(8)->inRandomOrder()->get()->toArray();
        $featuredProducts = Product::where(['is_featured'=>'Yes', 'status'=>1])->limit(6)->get()->toArray();
        return view('front.index')->with(compact('sliderBanners', 'fixBanners', 'newProducts', 'bestSellers', 'discountedProducts', 'featuredProducts'));
    }
}
