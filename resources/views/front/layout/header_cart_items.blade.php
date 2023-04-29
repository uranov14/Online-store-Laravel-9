@php
  use App\Models\Product;
  $getCartItems = getCartItems();
  $totalCartItems = totalCartItems();
@endphp

<!-- Mini Cart -->
<div class="mini-cart-wrapper">
  <div class="mini-cart">
    <div class="mini-cart-header">
      YOUR CART
      <a href="{{ url('/') }}">
        <button type="button" class="button ion ion-md-close" id="mini-cart-close"></button>
      </a>
    </div>
    <ul class="mini-cart-list">
      <?php 
        $total_price = 0; 
      ?>
      @foreach ($getCartItems as $item)
        @php
        $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
        //echo "<pre>"; print_r($getDiscountAttributePrice); die;
        @endphp
        <li class="clearfix">
          <a href="{{ url('product/'.$item['product_id']) }}">
          <img src="{{ asset('front/images/product_images/small/'.$item['product']['product_image']) }}" alt="Product">
          <span class="mini-item-name">{{ $item['product']['product_name'] }}</span>
          <span class="mini-item-price">{{ $getDiscountAttributePrice['final_price'] }}&nbsp;<span style="font-size: .675rem; color:black;">&#x20b4;</span></span>
          <span class="mini-item-quantity {{ $item['product_id'] }}"> x {{ $item['quantity'] }} </span>
          </a>
        </li>
        <?php 
          $total_price += $getDiscountAttributePrice['final_price'] * $item['quantity']; 
        ?>
      @endforeach
    </ul>
    {{-- <div class="mini-shop-total clearfix">
      <span class="float-left">Coupon Discount:</span>
      <span class="float-right">
        &nbsp;&#x20b4;
      </span>
      <span class="mini-total-price float-right couponAmount">
        0
      </span> 
    </div> --}}
    <div class="mini-shop-total clearfix">
      <span class="mini-total-heading float-left">Grand Total:</span>
      <span class="float-right">
        &nbsp;&#x20b4;
      </span>
      <span class="mini-total-price header_price float-right">
        @if ($totalCartItems == 0)
          {{ $total_price }}
        @else
          {{ $total_price - Session::get('couponAmount') }}
        @endif
      </span>
    </div>
    <div class="mini-action-anchors">
      <a href="{{ url('cart') }}" class="cart-anchor">View Cart</a>
      <a href="{{ url('checkout') }}" class="checkout-anchor">Checkout</a>
    </div>
  </div>
</div>
<!-- Mini Cart /- -->
