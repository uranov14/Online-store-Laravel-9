<?php use App\Models\Product; ?>

@extends('front.layout.layout')

@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
  <div class="container">
      <div class="page-intro">
          <h2>Order #{{ $orderDetails['id'] }}</h2>
          <ul class="bread-crumb">
              <li class="has-separator">
                  <i class="ion ion-md-home"></i>
                  <a href="index.html">Home</a>
              </li>
              <li class="is-marked">
                  <a href="{{ url('user/orders') }}">Orders</a>
              </li>
          </ul>
      </div>
  </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Cart-Page -->
<div class="page-cart u-s-p-t-80">
  <div class="container">
    <div class="row">
      <table class="table table-striped table-borderless">
        <thead>
          <tr align="center" class="table-danger">
            <th colspan="2">
              <strong>Order Details</strong>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>
              Order Date
            </th>
            <td>
              {{ date('Y-m-d h:i:s', strtotime($orderDetails['created_at'])) }}
            </td>
          </tr> 
          <tr>
            <th>
              Order Status
            </th>
            <td>
              {{ $orderDetails['order_status'] }}
            </td>
          </tr> 
          <tr>
            <th>
              Order Total
            </th>
            <td>
              {{ $orderDetails['grand_total'] }}
            </td>
          </tr> 
          <tr>
            <th>
              Shipping Charges
            </th>
            <td>
              {{ $orderDetails['shipping_charges'] }}
            </td>
          </tr> 
          @if (!empty($orderDetails['coupon_code']))
          <tr>
            <th>
              Coupon Code
            </th>
            <td>
              {{ $orderDetails['coupon_code'] }}
            </td>
          </tr> 
          <tr>
            <th>
              Coupon Amount
            </th>
            <td>
              {{ $orderDetails['coupon_amount'] }}
            </td>
          </tr> 
          @endif
          <tr>
            <th>
              Payment Method
            </th>
            <td>
              {{ $orderDetails['payment_method'] }}
            </td>
          </tr> 
        </tbody>
      </table>
      <table class="table table-striped table-dark mt-5">
        <thead>
          <tr align="center">
            <th colspan="6">
              <strong>Products Details</strong>
            </th>
          </tr>
          <tr>
            <th>#</th>
            <th>Product Image</th>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Product Size</th>
            <th>Product Color</th>
            <th>Product Qty</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($orderDetails['orders_products'] as $key => $product)
          <tr>
            <td>{{ $key+1 }}</td>
            <td>
              @php
                $getProductImage = Product::getProductImage($product['product_id'])
              @endphp
              <a target="_blank" href="{{ url('product/'.$product['product_id']) }}">
                <img width="50" src="{{ asset('front/images/product_images/small/'.$getProductImage) }}" alt="Product image">
              </a>
            </td>
            <td>
              {{ $product['product_code'] }}
            </td>
            <td>
              {{ $product['product_name'] }}
            </td>
            <td>
              {{ $product['product_size'] }}
            </td>
            <td>
              {{ $product['product_color'] }}
            </td>
            <td>
              {{ $product['product_qty'] }}
            </td>
          </tr> 
          @endforeach
        </tbody>
      </table>
      <table class="table table-striped table-borderless mt-5">
        <thead>
          <tr align="center" class="table-info">
            <th colspan="2">
              <strong>Delivery Address</strong>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>
              Name
            </th>
            <td>
              {{ $orderDetails['name'] }}
            </td>
          </tr> 
          <tr>
            <th>
              Address
            </th>
            <td>
              {{ $orderDetails['address'] }}
            </td>
          </tr> 
          <tr>
            <th>
              City
            </th>
            <td>
              {{ $orderDetails['city'] }}
            </td>
          </tr> 
          <tr>
            <th>
              State
            </th>
            <td>
              {{ $orderDetails['state'] }}
            </td>
          </tr> 
          <tr>
            <th>
              Country
            </th>
            <td>
              {{ $orderDetails['country'] }}
            </td>
          </tr> 
          <tr>
            <th>
              Pincode
            </th>
            <td>
              {{ $orderDetails['pincode'] }}
            </td>
          </tr> 
          <tr>
            <th>
              Mobile
            </th>
            <td>
              {{ $orderDetails['mobile'] }}
            </td>
          </tr> 
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- Cart-Page /- -->
@endsection