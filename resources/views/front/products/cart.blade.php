@extends('front.layout.layout')

@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
  <div class="container">
      <div class="page-intro">
          <h2>Cart</h2>
          <ul class="bread-crumb">
              <li class="has-separator">
                  <i class="ion ion-md-home"></i>
                  <a href="{{ url('/') }}">Home</a>
              </li>
              <li class="is-marked">
                  <a href="#">Cart</a>
              </li>
          </ul>
      </div>
  </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Cart-Page -->
<div class="page-cart u-s-p-t-80">
    <div class="container">
        @if (Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error: </strong><?php echo Session::get('error_message') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        @endif
            
        @if (Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success: </strong><?php echo Session::get('success_message') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                @if (empty($getCartItems))
                    <h1 class="text-center mb-5">Welcome! Your Cart is empty.</h1>
                @else
                    <div id="appendCartItems">
                        @include('front.products.cart_items')
                    </div>
                @endif
                <!-- Coupon -->
                <!-- Billing -->
                <div class="d-flex u-s-m-b-60">
                    <div class="coupon-area pt-4 col-lg-6">
                        <h6>Enter your coupon code if you have one.</h6>
                        <div class="coupon-field">
                            <form 
                                id="applyCoupon" 
                                method="post" 
                                action="javascript:;"
                                @if (Auth::check())
                                    user='1'
                                @endif
                            >
                            @csrf
                                <label class="sr-only" for="code">Apply Coupon</label>
                                <input id="code" name="code" type="text" class="text-field" placeholder="Enter Coupon Code">
                                <button type="submit" class="button">Apply Coupon</button>
                            </form>
                        </div>
                    </div>
                    <div class="table-wrapper-2 col-lg-6">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="2">Cart Totals</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <h6 class="calc-h3 u-s-m-b-0">Subtotal</h6>
                                    </td>
                                    <td>
                                        <span class="calc-text">{{ Session::get('total_price') }} <strong style="font-size: .675rem;">&#x20b4;</strong></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6 class="calc-h3 u-s-m-b-0">Coupon Discount</h6>
                                    </td>
                                    <td>
                                        <span class="calc-text couponAmount">
                                            @if (Session::has('couponAmount'))
                                                {{ Session::get('couponAmount') }}
                                            @else
                                                0
                                            @endif
                                        </span>
                                        <strong style="font-size: .675rem;">&#x20b4;</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6 class="calc-h3 u-s-m-b-0">Total</h6>
                                    </td>
                                    <td>
                                        <span class="calc-text grand_total">{{ Session::get('total_price') - Session::get('couponAmount') }}</span>&nbsp;<strong style="font-size: .675rem;">&#x20b4;</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Billing /- -->
                <div class="coupon-continue-checkout u-s-m-b-60">
                    <div class="button-area">
                        <a href="{{ url('/') }}" class="continue">Continue Shopping</a>
                        <a href="{{ url('/checkout') }}" class="checkout">Proceed to Checkout</a>
                    </div>
                </div>
                <!-- Coupon /- -->
            </div>
        </div>
    </div>
</div>
<!-- Cart-Page /- -->
@endsection