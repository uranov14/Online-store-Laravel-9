@extends('front.layout.layout')

@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
  <div class="container">
      <div class="page-intro">
          <h2>Checkout</h2>
          <ul class="bread-crumb">
              <li class="has-separator">
                  <i class="ion ion-md-home"></i>
                  <a href="index.html">Home</a>
              </li>
              <li class="is-marked">
                  <a href="checkout.html">Checkout</a>
              </li>
          </ul>
      </div>
  </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Checkout-Page -->
<div class="page-checkout u-s-p-t-80">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <div class="row">
          <!-- Billing-&-Shipping-Details -->
          <div id="deliveryAddresses" class="col-lg-6">
            @include('front.products.delivery_addresses')
          </div>
          <!-- Billing-&-Shipping-Details /- -->
          <!-- Checkout -->
          <div class="col-lg-6">
            <h4 class="section-h4">Your Order</h4>
            <div class="order-table">
              <table class="u-s-m-b-13">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $total_price = 0; ?>
                  @foreach ($getCartItems as $item)
                    @php
                      $getDiscountAttributePrice = App\Models\Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                      //echo "<pre>"; print_r($getDiscountAttributePrice); die;
                    @endphp
                    <tr>
                      <td style="width: 40%;">
                        <a href="{{ url('product/'.$item['product_id']) }}">
                          <img width="50" src="{{ asset('front/images/product_images/small/'.$item['product']['product_image']) }}" alt="Product">
                        </a>
                          <h6 style="position: relative; top: .5rem;" class="order-h6">
                            {{ $item['product']['product_name'] }}<br>{{ $item['size'] }}/{{ $item['product']['product_color'] }}
                          </h6>
                          <span style="float: right; position: relative; top: .8rem;" class="order-span-quantity">x {{ $item['quantity'] }}</span>
                      </td>
                      <td>
                        <h6 class="order-h6">
                          {{ $getDiscountAttributePrice['final_price'] * $item['quantity'] }}&nbsp;<span style="font-size: .675rem; color:black;">&#x20b4;</span>
                        </h6>
                      </td>
                    </tr>
                    <?php $total_price += $getDiscountAttributePrice['final_price'] * $item['quantity']; ?>
                  @endforeach
                  <?php Session::put('total_price', $total_price); ?>
                  <tr>
                    <td>
                      <h3 class="order-h3">Subtotal</h3>
                    </td>
                    <td>
                      <h3 class="order-h3">{{ $total_price }} <strong style="font-size: .675rem;">&#x20b4;</strong></h3>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h6 class="order-h6">Shipping Charges</h6>
                    </td>
                    <td>
                      <h6 class="order-h6">0 <strong style="font-size: .675rem;">&#x20b4;</strong></h6>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h6 class="order-h6">Coupon Discount</h6>
                    </td>
                    <td>
                      <h6 class="order-h6">
                        @if (Session::has('couponAmount'))
                          {{ Session::get('couponAmount') }}
                        @else
                          0
                        @endif
                        <strong style="font-size: .675rem;">&#x20b4;</strong>
                      </h6>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h3 class="order-h3">Grand Total</h3>
                    </td>
                    <td>
                      <h3 class="order-h3">
                        {{ Session::get('total_price') - Session::get('couponAmount') }}&nbsp;<strong style="font-size: .675rem;">&#x20b4;</strong>
                      </h3>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="u-s-m-b-13">
                  <input type="radio" class="radio-box" name="payment-method" id="cash-on-delivery">
                  <label class="label-text" for="cash-on-delivery">Cash on Delivery</label>
              </div>
              <div class="u-s-m-b-13">
                  <input type="radio" class="radio-box" name="payment-method" id="credit-card-stripe">
                  <label class="label-text" for="credit-card-stripe">Credit Card (Stripe)</label>
              </div>
              <div class="u-s-m-b-13">
                  <input type="radio" class="radio-box" name="payment-method" id="paypal">
                  <label class="label-text" for="paypal">Paypal</label>
              </div>
              <div class="u-s-m-b-13">
                  <input type="checkbox" class="check-box" id="accept">
                  <label class="label-text no-color" for="accept">I’ve read and accept the
                      <a href="terms-and-conditions.html" class="u-c-brand">terms & conditions</a>
                  </label>
              </div>
              <button type="submit" class="button button-outline-secondary">Place Order</button>
            </div>
          </div>
          <!-- Checkout /- -->
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Checkout-Page /- -->
@endsection