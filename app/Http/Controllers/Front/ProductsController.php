<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductsController extends Controller
{
    public function listing(Request $request) {
        //echo "test"; die;
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $url = $data['url'];
            $_GET['sort'] = $data['sort'];
            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();

            if ($categoryCount > 0) {
                $categoryDetails = Category::categoryDetails($url);
                //dd($categoryDetails);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
                
                //checking for Sort
                if (isset($_GET['sort']) && !empty($_GET['sort'])) {
                    if ($_GET['sort'] == 'product_latest') {
                        $categoryProducts->orderBy('products.id', 'Desc');
                    } else if ($_GET['sort'] == 'price_lowest') {
                        $categoryProducts->orderBy('products.product_price', 'Asc');
                    } else if ($_GET['sort'] == 'price_highest') {
                        $categoryProducts->orderBy('products.product_price', 'Desc');
                    } else if ($_GET['sort'] == 'name_a_z') {
                        $categoryProducts->orderBy('products.product_name', 'Asc');
                    } else if ($_GET['sort'] == 'name_z_a') {
                        $categoryProducts->orderBy('products.product_name', 'Desc');
                    }
                }

                $categoryProducts = $categoryProducts->paginate(3);
                //dd($categoryProducts);
                return view('front.products.ajax_products_listing')->with(compact('categoryDetails', 'categoryProducts'));
            } else {
                abort(404);
            }
        } else {
            $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();

            if ($categoryCount > 0) {
                //echo "Category exists"; die;
                $categoryDetails = Category::categoryDetails($url);
                //dd($categoryDetails);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
                
                //checking for Sort
                if (isset($_GET['sort']) && !empty($_GET['sort'])) {
                    if ($_GET['sort'] == 'product_latest') {
                        $categoryProducts->orderBy('products.id', 'Desc');
                    } else if ($_GET['sort'] == 'price_lowest') {
                        $categoryProducts->orderBy('products.product_price', 'Asc');
                    } else if ($_GET['sort'] == 'price_highest') {
                        $categoryProducts->orderBy('products.product_price', 'Desc');
                    } else if ($_GET['sort'] == 'name_a_z') {
                        $categoryProducts->orderBy('products.product_name', 'Asc');
                    } else if ($_GET['sort'] == 'name_z_a') {
                        $categoryProducts->orderBy('products.product_name', 'Desc');
                    }
                }

                $categoryProducts = $categoryProducts->paginate(4);
                //dd($categoryProducts);
                return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts'));
            } else {
                abort(404);
            }
        }
        
    }
}
