<?php
use App\Models\Cart;

function totalCartItems() {
  if (Auth::check()) {
    $user_id = Auth::user()->id;
    $totalCartItems = Cart::where('user_id', $user_id)->sum('quantity');
  } else {
    $session_id = Session::get('session_id');
    $totalCartItems = Cart::where('session_id', $session_id)->sum('quantity');
  }
  return $totalCartItems;
}

function getCartItems() {
  if (Auth::check()) {
    //User is Logged in / pick auth id of the User
    $user_id = Auth::user()->id;
    $getCartItems = Cart::with(['product'=>function($query) {
      $query->select('id', 'category_id', 'product_name', 'product_code', 'product_color', 'product_price', 'product_image');
    }])->orderBy('id','Desc')->where('user_id', $user_id)->get()->toArray();
  } else {
    //User is not Logged in / pick session id of the User
    $getCartItems = Cart::with(['product'=>function($query) {
      $query->select('id', 'category_id', 'product_name', 'product_code', 'product_color', 'product_price', 'product_image');
    }])->orderBy('id','Desc')->where('session_id', Session::get('session_id'))->get()->toArray();
  }

  return $getCartItems;
}