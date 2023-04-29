<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CmsPage;
use App\Models\Section;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsFilter;
use App\Models\Cart;
use Validator;

class APIController extends Controller
{
    public function registerUser(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ];

            $customMessage = [
                'name.required' => 'Name is required!',
                'email.required' => 'Email Address is required!',
                'email.email' => 'Valid Email is required!',
                'email.unique' => 'Email already exists!',
                'password.required' => 'Password is required!'
            ];

            $validator =Validator::make($data, $rules, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            //Create User Account
            //Insert the user Details in users table
            $user = new User;
            $user->name = $data['name'];
            $user->mobile = $data['mobile'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->status = 1;

            //Set Default Timezone to Ukraine
            date_default_timezone_set("Europe/Kyiv");
            $user->created_at = date("Y-m-d H:i:s");
            $user->updated_at = date("Y-m-d H:i:s");

            $user->save();

            return response()->json([
                'status'=>true,
                'message'=>"User registered succesfully!"
            ], 201);
        }
    }

    public function loginUser(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $rules = [
                'email' => 'required|email|exists:users',
                'password' => 'required'
            ];

            $customMessage = [
                'email.required' => 'Email Address is required!',
                'email.email' => 'Valid Email is required!',
                'email.exists' => 'Email does not exists!',
                'password.required' => 'Password is required!'
            ];

            $validator =Validator::make($data, $rules, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            //Verify User Email
            $userCount = User::where('email', $data['email'])->count();
            if ($userCount > 0) {
                //Fetch User Details
                $userDetails = User::where('email', $data['email'])->first();

                //Verify Password
                if (password_verify($data['password'], $userDetails->password)) {
                    return response()->json([
                        'userDetails'=>$userDetails,
                        'status'=>true,
                        'message'=>"User login succesfully!"
                    ], 201);
                } else {
                    $message = "Password is Incorrect.";
                    return response()->json([
                        'status'=>false,
                        'message'=>$message
                    ], 422);
                }
            } else {
                $message = "Email is Incorrect.";
                return response()->json([
                    'status'=>false,
                    'message'=>$message
                ], 422);
            }

            /* return response()->json([
                'status'=>true,
                'message'=>"User login succesfully!"
            ], 201); */
        }
    }

    public function updateUser(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->input();
            //echo "<pre>"; print_r($data); die; 

            $rules = [
                'name' => 'required'
            ];

            $customMessage = [
                'name.required' => 'Name is required!'
            ];

            $validator =Validator::make($data, $rules, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            //Verify User ID
            $userCount = User::where('id', $data['id'])->count();
            if ($userCount > 0) {
                if (empty($data['city'])) {
                    $data['city'] = "";
                }
                if (empty($data['state'])) {
                    $data['state'] = "";
                }
                if (empty($data['country'])) {
                    $data['country'] = "";
                }
                if (empty($data['pincode'])) {
                    $data['pincode'] = "";
                }
                //Update User Details
                User::where('id', $data['id'])->update(['name'=>$data['name'], 'address'=>$data['address'], 'city'=>$data['city'], 'state'=>$data['state'], 'country'=>$data['country'], 'pincode'=>$data['pincode']]);

                //Fetch User Details
                $userDetails = User::where('id', $data['id'])->first();

                return response()->json([
                    'userDetails'=>$userDetails,
                    'status'=>true,
                    'message'=>"User Updated succesfully!"
                ], 201);

            } else {
                $message = "User does not exists.";
                return response()->json([
                    'status'=>false,
                    'message'=>$message
                ], 422);
            }
            
        }
        
    }

    public function cmsPage() {
        $currentRoute = url()->current();
        $currentRoute = str_replace("http://127.0.0.1:8000/api/", "", $currentRoute);
        /* echo $currentRoute; die; */
        $cmsUrls = CmsPage::select('url')->where('status', 1)->get()->pluck('url')->toArray();

        if (in_array($currentRoute, $cmsUrls)) {
            $cmsPageDetails = CmsPage::where('url', $currentRoute)->get();
            return response()->json([
                'status'=>true,
                'cmsPageDetails'=>$cmsPageDetails,
                'message'=>"Page details fetched successfully!"
            ], 200);
        } else {
            $message = "Page does not exists.";
            return response()->json([
                'status'=>false,
                'message'=>$message
            ], 422);
        }
    }

    public function menuCat() {
        /* header('Access-Control-Allow-Origin: *'); */
        $categories = Section::with('categories')->get();
        return response()->json(['categories'=>$categories], 200);
    }

    public function listing($url) {
        $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
        if ($categoryCount > 0) {
            $categoryDetails = Category::categoryDetails($url);
                
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

            $productIds = array();
            if (isset($data['price']) && !empty($data['price'])) {                    
                foreach ($data['price'] as $key => $price) {
                    $priceArr = explode('-', $price);
                    if (isset($priceArr[0]) && isset($priceArr[1])) {
                        $productIds[] = Product::select('id')->whereBetween('product_price', [$priceArr[0], $priceArr[1]])->pluck('id')->toArray();
                    }
                }                    
                $productIds = array_unique(array_flatten($productIds));
                $categoryProducts->whereIn('products.id', $productIds);
            }

            //checking for Brand
            if (isset($data['brand']) && !empty($data['brand'])) {
                $productIds = Product::select('id')->whereIn('brand_id', $data['brand'])->pluck('id')->toArray();
                $categoryProducts->whereIn('products.id', $productIds);
            }

            $categoryProducts = $categoryProducts->get();
            foreach ($categoryProducts as $key => $product) {
                $getDiscountPrice = Product::getDiscountPrice($product['id']);
                if ($product['product_price'] > $getDiscountPrice) {
                    $product['final_price'] = $getDiscountPrice." $";
                } else {
                    $product['final_price'] = $product['product_price']." $";
                }

                $product['product_image'] = url('front/images/product_images/small/'.$product['product_image']);
            }

            return response()->json(['products'=>$categoryProducts], 200);

        } else {
            $message = "Category does not exists.";
            return response()->json([
                'status'=>false,
                'message'=>$message
            ], 422);
        }
    }

    public function detail($id) {
        $productCount = Product::where(['id'=>$id, 'status'=>1])->count();
        if ($productCount > 0) {
            $productDetails = Product::with(['section', 'category', 'brand', 'attributes'=>function($query) { 
                $query->where('stock', '>', 0)->where('status', 1);
            }, 'vendor', 'images'])->where('id', $id)->get();

            foreach ($productDetails as $key => $product_detail) {
                $getDiscountPrice = Product::getDiscountPrice($product_detail['id']);
                if ($product_detail['product_price'] > $getDiscountPrice) {
                    $product_detail['final_price'] = $getDiscountPrice;
                } else {
                    $product_detail['final_price'] = $product_detail['product_price'];
                }

                $product_detail['product_image'] = url('front/images/product_images/small/'.$product_detail['product_image']);
            }

            return response()->json(['product'=>$productDetails], 200);

        } else {
            $message = "Product is not available.";
            return response()->json([
                'status'=>false,
                'message'=>$message
            ], 422);
        }
        
    }

    public function addtoCart(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->input();
            
            //Check Product if already exists in the User Cart
            $countProducts = Cart::where(['product_id'=>$data['productid'], 'size'=>$data['size'], 'user_id'=>$data['userid']])->count();
            if ($countProducts > 0) {
                $message = "Product already exists in the User Cart";
                return response()->json([
                    'status'=>false,
                    'message'=>$message
                ], 422);
            }
            
            //Save Product in carts table
            $item = new Cart;
            $item->session_id = 0;
            $item->user_id = $data['userid'];
            $item->product_id = $data['productid'];
            $item->size = $data['size'];
            $item->quantity = 1;
            $item->source = "App";
            $item->save();

            return response()->json([
                'status'=>true,
                'message'=>"Product added to User Cart succesfully!"
            ], 201);
        }
    }

    public function cart($userid) {
        $getCartItems = Cart::with(['product'=>function($query) {
            $query->select('id', 'category_id', 'product_name', 'product_code', 'product_color', 'product_price', 'product_image', 'product_weight');
        }])->orderBy('id','Desc')->where('user_id', $userid)->get();
        //dd($getCartItems);
        foreach ($getCartItems as $key => $item) {
            $getDiscountPrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
            if ($getDiscountPrice > 0) {
                $item['product']['final_price'] = $getDiscountPrice." $";
            } else {
                $item['product']['final_price'] = $item['product']['product_price']." $";
            }

            $item['product']['product_image'] = url('front/images/product_images/small/'.$item['product']['product_image']);
        }
        return response()->json(['products'=>$getCartItems], 200);
    }

    public function checkout($userid) {
        $getCartItems = Cart::with(['product'=>function($query) {
            $query->select('id', 'category_id', 'product_name', 'product_code', 'product_color', 'product_price', 'product_image', 'product_weight');
        }])->orderBy('id','Desc')->where('user_id', $userid)->get();
        //dd($getCartItems);

        $total_price = 0;
        foreach ($getCartItems as $key => $item) {
            $getDiscountPrice = Product::getDiscountPrice($item['product_id']);
            if ($item['product']['product_price'] > $getDiscountPrice) {
                $item['product']['final_price'] = $getDiscountPrice." $";
                $total_price += $getDiscountPrice;
            } else {
                $item['product']['final_price'] = $item['product']['product_price']." $";
                $total_price += $item['product']['product_price'];
            }

            $item['product']['product_image'] = url('front/images/product_images/small/'.$item['product']['product_image']);
            $item['product']['total_price'] = $total_price;
            $item['product']['key'] = $key;
        }
        //echo $total_price; die;
        return response()->json(['products'=>$getCartItems], 200);
    }

    public function deleteCartItem($cartid) {
        Cart::where('id', $cartid)->delete();

        return response()->json([
            'status'=>true,
            'message'=>"Product from Cart deleted succesfully!"
        ], 200);
    }
}
