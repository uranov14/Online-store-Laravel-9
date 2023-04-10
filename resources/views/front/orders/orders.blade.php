@extends('front.layout.layout')

@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
  <div class="container">
      <div class="page-intro">
          <h2>My Orders</h2>
          <ul class="bread-crumb">
              <li class="has-separator">
                  <i class="ion ion-md-home"></i>
                  <a href="index.html">Home</a>
              </li>
              <li class="is-marked">
                  <a href="#">Orders</a>
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
      <table class="table table-hover">
        <thead>
          <tr class="table-danger">
            <th>
              Order ID
            </th>
            <th>
              Ordered Products
            </th>
            <th>
              Payment Method
            </th>
            <th>
              Grand Total
            </th>
            <th>
              Created on
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($orders as $order)
          <tr>
            <td>
              <a href="{{ url('user/orders/'.$order['id']) }}">
                {{ $order['id'] }}
              </a>
            </td>
            <td>
              @foreach ($order['orders_products'] as $product)
                {{ $product['product_name'] }} ({{ $product['product_code'] }}/{{ $product['product_size'] }})  x {{ $product['product_qty'] }}<br>
              @endforeach
            </td>
            <td>
              {{ $order['payment_method'] }}
            </td>
            <td>
              {{ $order['grand_total'] }}
            </td>
            <td>
              {{ date('Y-m-d h:i:s', strtotime($order['created_at'])) }}
            </td>
          </tr>  
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- Cart-Page /- -->
@endsection