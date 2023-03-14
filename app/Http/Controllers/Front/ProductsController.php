<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsFilter; 
use App\Models\ProductsAttribute; 
use App\Models\Vendor;

class ProductsController extends Controller
{
    public function listing(Request $request) {
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
                
                //Checking for Dynamic Filters
                $productFilters = ProductsFilter::productFilters();
                foreach($productFilters as $filters) {
                    if (isset($data[$filters['filter_column']]) && !empty($data[$filters['filter_column']])) {
                        $categoryProducts->whereIn('products.'.$filters['filter_column'], $data[$filters['filter_column']]);
                    }
                }
                
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
                        $categoryProducts->orderBy('get_filterproduct_name', 'Desc');
                    }
                }

                //checking for Size
                if (isset($data['size']) && !empty($data['size'])) {
                    $productIds = ProductsAttribute::select('product_id')->whereIn('size', $data['size'])->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id', $productIds);
                }

                //checking for Color
                if (isset($data['color']) && !empty($data['color'])) {
                    $productIds = Product::select('id')->whereIn('product_color', $data['color'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id', $productIds);
                }

                //checking for Price
                if (isset($data['price']) && !empty($data['price'])) {
                    //echo "<pre>"; print_r($data['price']); die;
                    
                    foreach ($data['price'] as $key => $price) {
                        $priceArr = explode('-', $price);
                        $productIds[] = Product::select('id')->whereBetween('product_price', [$priceArr[0], $priceArr[1]])->pluck('id')->toArray();
                    }
                    
                    $productIds = call_user_func_array('array_merge', $productIds);
                    //echo "<pre>"; print_r($productIds); die;
                    $categoryProducts->whereIn('products.id', $productIds);
                    /* $implodePrices = implode('-', $data['price']);
                    $explodePrices = explode('-', $implodePrices);
                    $min = reset($explodePrices);
                    $max = end($explodePrices);

                    $productIds = Product::select('id')->whereBetween('product_price', [$min, $max])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id', $productIds); */
                }

                //checking for Brand
                if (isset($data['brand']) && !empty($data['brand'])) {
                    $productIds = Product::select('id')->whereIn('brand_id', $data['brand'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id', $productIds);
                }

                $categoryProducts = $categoryProducts->paginate(30);
                //dd($categoryProducts);
                return view('front.products.ajax_products_listing')->with(compact('categoryDetails', 'categoryProducts', 'url'));
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

                $categoryProducts = $categoryProducts->paginate(9);
                //dd($categoryProducts);
                return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts', 'url'));
            } else {
                abort(404);
            }
        }
        
    }

    public function vendorListing($vendorid) {
        //Get Vendor Shop Name
        $getVendorShop = Vendor::getVendorShop($vendorid);

        //Get Vendor Products
        $vendorProducts = Product::with('brand')->where(['vendor_id'=>$vendorid, 'status'=>1]);

        $vendorProducts = $vendorProducts->paginate(30);
        //dd($vendorProducts);
        return view('front.products.vendor_listing')->with(compact('getVendorShop', 'vendorProducts'));
    }

    public function detail($id) {
        $productDetails = Product::with(['section', 'category', 'brand', 'attributes'=>function($query) { 
            $query->where('stock', '>', 0)->where('status', 1);
         }, 'vendor', 'images'])->find($id)->toArray();
        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);
        //dd($productDetails);
        $totalStock = ProductsAttribute::where('product_id', $id)->sum('stock');

        return view('front.products.detail')->with(compact('productDetails', 'categoryDetails', 'totalStock'));
    }

    public function getProductPrice(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'], $data['size']);

            return $getDiscountAttributePrice;
        }
    }
}
