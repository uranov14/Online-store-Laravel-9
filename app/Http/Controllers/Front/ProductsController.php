<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsFilter; 
use App\Models\ProductsAttribute; 
use App\Models\Vendor;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\User;
use App\Models\DeliveryAddress;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Sms;
use Session;
use DB;
use Auth;

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
                /* if (isset($data['price']) && !empty($data['price'])) {                    
                    foreach ($data['price'] as $key => $price) {
                        $priceArr = explode('-', $price);
                        $productIds[] = Product::select('id')->whereBetween('product_price', [$priceArr[0], $priceArr[1]])->pluck('id')->toArray();
                    }                    
                    $productIds = call_user_func_array('array_merge', $productIds);
                    $categoryProducts->whereIn('products.id', $productIds);
                } */

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

        //Get Similar Products
        $similarProducts = Product::with('brand')->where('category_id', $productDetails['category']['id'])->where('id', '!=', $id)->limit(6)->inRandomOrder()->get()->toArray();
        //dd($similarProducts);
        
        //Set Session for Viewed Recently Products
        if (empty(Session::get('session_id'))) {
            $session_id = md5(uniqid(rand(), true));
        } else {
            $session_id = Session::get('session_id');
        }

        Session::put('session_id', $session_id);

        //Insert product in table if not exists
        $countRecentlyViewedProducts = DB::table('recently_viewed_products')->where(['product_id'=> $id, 'session_id'=>$session_id])->count();
        if ($countRecentlyViewedProducts == 0) {
            DB::table('recently_viewed_products')->insert(['product_id'=> $id, 'session_id'=>$session_id]);
        }

        //Get Recently Viewed Products Ids
        $recentlyViewedProductsIds = DB::table('recently_viewed_products')->select('product_id')->where('product_id', '!=', $id)->where('session_id', $session_id)->inRandomOrder()->get()->take(4)->pluck('product_id');
        //dd($recentlyViewedProductsIds);

        //Get Recently Viewed Products
        $recentlyViewedProducts = Product::with('brand')->whereIn('id', $recentlyViewedProductsIds)->get()->toArray();
        //dd($recentlyViewedProducts);

        //Get Group Products
        $groupProducts = array();
        if (!empty($productDetails['group_code'])) {
            $groupProducts = Product::select('id', 'product_image')->where('id', '!=', $id)->where(['group_code'=> $productDetails['group_code'], 'status'=>1])->get()->toArray();
            //dd($groupProducts);
        }

        $totalStock = ProductsAttribute::where('product_id', $id)->sum('stock');

        return view('front.products.detail')->with(compact('productDetails', 'categoryDetails', 'totalStock', 'similarProducts', 'recentlyViewedProducts', 'groupProducts'));
    }

    public function getProductPrice(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'], $data['size']);

            return $getDiscountAttributePrice;
        }
    }

    public function cartAdd(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            //Check Product Stock is available or not
            $getProductStock = ProductsAttribute::isStockAvailable($data['product_id'], $data['size']);

            if ($getProductStock < $data['quantity']) {
                return redirect()->back()->with('error_message', 'Required Quantity is not available!');
            }

            //Generate Session Id if not exists
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id', $session_id);
            }

            //Check Product if already exists in the User Cart
            if (Auth::check()) {
                //User is Logged in
                $user_id = Auth::user()->id;
                $countProducts = Cart::where(['product_id'=>$data['product_id'], 'size'=>$data['size'], 'user_id'=>$user_id])->count();
            } else {
                //User is not Logged in
                $user_id = 0;
                $countProducts = Cart::where(['product_id'=>$data['product_id'], 'size'=>$data['size'], 'session_id'=>$session_id])->count();
            }

            if ($countProducts > 0) {
                return redirect()->back()->with('error_message', 'Product already exists in Cart!');
            }

            //Save Product in cart table
            $item = new Cart;
            $item->session_id = $session_id;
            $item->user_id = $user_id;
            $item->product_id = $data['product_id'];
            $item->size = $data['size'];
            $item->quantity = $data['quantity'];
            $item->save();

            return redirect()->back()->with('success_message', 'Product has been added in Cart! <a style="text-decoration: underline;" href="/cart">View Cart</a>');
        }
    }

    public function cart() {
        $getCartItems = Cart::getCartItems();
        //dd($getCartItems);
        return view('front.products.cart')->with(compact('getCartItems'));
    }

    public function cartUpdate(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            //Get Cart Details
            $cartDetails = Cart::find($data['cartid']);

            //Get Available Product Stock
            $availableStock = ProductsAttribute::select('stock')->where(['product_id'=>$cartDetails['product_id'], 'size'=>$cartDetails['size']])->first()->toArray();
            //echo "<pre>"; print_r($availableStock); die;

            //Check if desired Stock from user is available
            if ($data['qty'] > $availableStock['stock']) {
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status'=>false, 
                    'message'=>'Product Stock is not available!',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems'))
                ]);
            }

            //Check if product size is available
            $availableSize = ProductsAttribute::where(['product_id'=>$cartDetails['product_id'], 'size'=>$cartDetails['size'], 'status'=>1])->count();
            if ($availableSize == 0) {
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status'=>false, 
                    'message'=>'Product Size is not available! Please remove this Product and choose another one!',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems'))
                ]);
            }

            //Update quantity in carts table
            Cart::where('id', $data['cartid'])->update(['quantity'=>$data['qty']]);
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            Session::forget('couponCode');
            Session::forget('couponAmount');
            return response()->json([
                'status'=>true, 
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems'))
            ]);
        }
        return view('front.products.cart')->with(compact('getCartItems'));
    }

    public function cartDelete(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            Session::forget('couponCode');
            Session::forget('couponAmount');

            //Delete cart
            Cart::where('id', $data['cartid'])->delete();
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            return response()->json([ 
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems'))
            ]);
        }
    }

    public function applyCoupon(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            Session::forget('couponCode');
            Session::forget('couponAmount');
            
            $getCartItems = Cart::getCartItems();  
            //echo "<pre>"; print_r($getCartItems); die;        
            $totalCartItems = totalCartItems();
            $couponCount = Coupon::where('coupon_code', $data['code'])->count();
            if ($couponCount == 0) {
                return response()->json([ 
                    'status'=>false,
                    'totalCartItems'=>$totalCartItems,
                    'message'=>'The coupon is not valid!',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'headerView'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
            } else {
                //Check for other coupon conditions
                //Get Coupon Details
                $couponDetails = Coupon::where('coupon_code', $data['code'])->first();
                //Check if Coupon is active and is expired
                if ($couponDetails->status == 0) {
                    $message = "The coupon is not active!";
                } else if ($couponDetails->expiry_date < date('Y-m-d')) {
                    //Check if Coupon is expired
                    $message = "The coupon is expired!";
                } 

                //Check if Coupon is for single time
                if ($couponDetails->coupon_type == "Single Time") {
                    //Check in orders table if coupon already availed by the user
                    $couponCount = Order::where(['coupon_code' => $data['code'], 'user_id' => Auth::user()->id])->count();
                    if ($couponCount >= 1) {
                        $message = "This coupon code already availed by you!";
                    }
                }

                //Get all selected categories from coupon and convert to array
                $catArr = explode(",", $couponDetails->categories);
                //echo "<pre>"; print_r($getCartItems); die;
                //Check if Coupon is from selected categories
                $total_amount = 0;
                foreach ($getCartItems as $key => $item) {
                    if (!in_array($item['product']['category_id'], $catArr)) {
                        $message = "This coupon code is not for one of the selected products!";
                    }
                    $attrPrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                    $total_amount += $attrPrice['final_price'] * $item['quantity'];
                }

                //Get all selected users from coupon and convert to array
                if (isset($couponDetails->users) && !empty($couponDetails->users)) {
                    $usersArr = explode(",", $couponDetails->users);

                    if (count($usersArr) > 0) {
                        //Get User Id's of all selected users
                        foreach ($usersArr as $key => $user) {
                            $getUserId = User::select('id')->where('email', $user)->first()->toArray();
                            $usersId[] = $getUserId['id'];
                        }

                        //Check if any cart item not belong to Coupon user
                        foreach ($getCartItems as $item) {
                            if (!in_array($item['user_id'], $usersId)) {
                                $message = "This coupon code is not for you! Try with valid coupon code!";
                            }                       
                        }
                    }
                }

                //Check if coupon belong to Vendor
                if ($couponDetails->vendor_id > 0) {
                    $productIds = Product::select('id')->where('vendor_id', $couponDetails->vendor_id)->pluck('id')->toArray();
                    //echo "<pre>"; print_r($productIds); die;
                    foreach ($getCartItems as $item) {
                        if (!in_array($item['product']['id'], $productIds)) {
                            $message = "This coupon code is not for you! Try with valid coupon code (Vendor validation)!";
                        }
                    }
                }
                    
                if (isset($message)) {
                    return response()->json([ 
                        'status'=>false,
                        'totalCartItems'=>$totalCartItems,
                        'message'=>$message,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                        'headerView'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                    ]);
                } else {
                    //Coupon code is correct
                    //Check if Coupon Amount type is Fixed or Percentage
                    if ($couponDetails->amount_type == "Fixed") {
                        $couponAmount = $couponDetails->amount;
                    } else {
                        $couponAmount = $total_amount * ($couponDetails->amount / 100);
                    }
                    $grand_total = $total_amount - $couponAmount;

                    //Add Coupon Code & Amount in Session variables
                    Session::put('couponCode', $data['code']);
                    Session::put('couponAmount', $couponAmount);

                    $message = "Coupon Code successfully applied! You are availing discount!";

                    return response()->json([ 
                        'status'=>true,
                        'totalCartItems'=>$totalCartItems,
                        'couponAmount'=>$couponAmount,
                        'grand_total'=>$grand_total,
                        'message'=>$message,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                        'headerView'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                    ]);
                }
                
            }
        }
    }

    public function checkout(Request $request) {
        $deliveryAddress = DeliveryAddress::deliveryAddress();
        //dd($deliveryAddress);
        $countries = Country::where('status', 1)->get()->toArray();
        $getCartItems = Cart::getCartItems();
        //dd($getCartItems);
        if (count($getCartItems) == 0) {
            $message = "Shoping cart is empty. Please add products to checkout!";
            return redirect('cart')->with('error_message', $message);
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            //Delivery Address Validation
            if (empty($data['address_id'])) {
                $message= "Please select Delivery Address!";
                return redirect()->back()->with('error_message', $message);
            }

            //Payment Method Validation
            if (empty($data['payment_gateway'])) {
                $message= "Please select Payment Method!";
                return redirect()->back()->with('error_message', $message);
            }

            //Accept T&C
            if (empty($data['accept'])) {
                $message= "Please agree to T&C!";
                return redirect()->back()->with('error_message', $message);
            }
            //echo "<pre>"; print_r($data); die;
            //Get Delivery Address from address_id
            $deliveryAddress = DeliveryAddress::where('id', $data['address_id'])->first()->toArray();
            //dd($deliveryAddress);

            //Set Payment Method as COD if COD is selected from user otherwise set as Prepaid
            if ($data['payment_gateway'] == "COD") {
                $payment_method = "COD";
                $order_status = "New";
            } else {
                $payment_method = "Prepaid";
                $order_status = "Pending";
            }

            DB::beginTransaction();
            
            //Fetch Order Total Price
            $total_price = 0;
            foreach ($getCartItems as $item) {
                $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                $total_price += $getDiscountAttributePrice['final_price'] * $item['quantity'];
            }

            //Calculate Shipping Charges
            $shipping_charges = 0;
            //Calculate Grand Total
            $grand_total = $total_price + $shipping_charges - Session::get('couponAmount');

            //Insert Grand Total in Session Variable
            Session::put('grand_total', $grand_total);

            //Insert Order Details
            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->name = $deliveryAddress['name'];
            $order->address = $deliveryAddress['address'];
            $order->city = $deliveryAddress['city'];
            $order->state = $deliveryAddress['state'];
            $order->country = $deliveryAddress['country'];
            $order->pincode = $deliveryAddress['pincode'];
            $order->mobile = $deliveryAddress['mobile'];
            $order->email = Auth::user()->email;
            $order->shipping_charges = $shipping_charges;
            $order->coupon_code = Session::get('couponCode');
            $order->coupon_amount = Session::get('couponAmount');
            $order->order_status = $order_status;
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->grand_total = $grand_total;
            $order->save();

            $order_id = DB::getPdo()->lastInsertId();

            foreach ($getCartItems as $item) {
                $cartItem = new OrderProduct;
                $cartItem->order_id = $order_id;
                $cartItem->user_id = Auth::user()->id;

                $getProductDetails = Product::select('product_code', 'product_name', 'product_color', 'admin_id', 'vendor_id')->where('id', $item['product_id'])->first()->toArray();
                
                $cartItem->admin_id = $getProductDetails['admin_id'];
                $cartItem->vendor_id = $getProductDetails['vendor_id'];
                $cartItem->product_id = $item['product_id'];
                $cartItem->product_code = $getProductDetails['product_code'];
                $cartItem->product_name = $getProductDetails['product_name'];
                $cartItem->product_color = $getProductDetails['product_color'];
                $cartItem->product_size = $item['size'];
                $cartItem->product_color = $getProductDetails['product_color'];
                $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                $cartItem->product_price = $getDiscountAttributePrice['final_price'];
                $cartItem->product_qty = $item['quantity'];
                $cartItem->save();
            }

            //Insert Order Id in Session Variable
            Session::put('order_id', $order_id);

            DB::commit();

            $orderDetails = Order::with('orders_products')->where('id', $order_id)->first()->toArray();

            if ($data['payment_gateway'] == "COD") {
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

                //Send Order SMS
                /* $message = "Dear Customer, your order ".$order_id."has been successfully placed! We will intimate you once your order is shipped.";
                $mobile = Auth::user()->mobile;

                Sms::sendSms($message, $mobile); */
            } else if ($data['payment_gateway'] == "Paypal") {
                //Redirect User to Paypal Page after saving order
                return redirect('/paypal');
            } else {
                echo "Other Prepaid Payment methods coming soon";
            }

            return redirect('thanks');
        }
        
        return view('front.products.checkout')->with(compact('deliveryAddress', 'countries', 'getCartItems'));
    }

    public function thanks() {
        if (Session::has('order_id')) {
            //Empty the Cart
            Cart::where('user_id', Auth::user()->id)->delete();
            Session::forget('couponCode'); 
            Session::forget('couponAmount');
            return view('front.products.thanks');
        } else {
            return redirect('cart');
        }
    }
}
