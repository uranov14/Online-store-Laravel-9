<?php 
use App\Models\Product; 
use App\Models\OrdersLog; 
?>

@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">
    @if (Session::has('success_message'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success: </strong>{{ Session::get('success_message') }}
        <button type="button" class="close pt-1" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="row">
          <div class="col-12 col-xl-8 mb-4 mb-xl-0">
            <h3 class="font-weight-bold">
                Order # {{ $orderDetails['id'] }}
            </h3>
            <h6 class="font-weight-normal mb-1">
              <a href="{{ url('admin/orders') }}">Back to Orders</a>
            </h6>
          </div>
          <div class="col-12 col-xl-4">
            <div class="justify-content-end d-flex">
              <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                  <a class="dropdown-item" href="#">January - March</a>
                  <a class="dropdown-item" href="#">March - June</a>
                  <a class="dropdown-item" href="#">June - August</a>
                  <a class="dropdown-item" href="#">August - November</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Order Details</h4>
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Order Date: </label>
              <label>{{ date('Y-m-d h:i:s', strtotime($orderDetails['created_at'])) }}</label>
            </div>
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Order Status: </label>
              <label>{{ $orderDetails['order_status'] }}</label>
            </div>
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Order Total: </label>
              <label>{{ $orderDetails['grand_total'] }} <span style="font-size: .75rem; color:black;">&#x20b4;</span></label>
            </div>
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Shipping Charges: </label>
              <label>{{ $orderDetails['shipping_charges'] }} <span style="font-size: .75rem; color:black;">&#x20b4;</span></label>
            </div>
            @if (!empty($orderDetails['coupon_code']))
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Coupon Code: </label>
              <label>{{ $orderDetails['coupon_code'] }}</label>
            </div>
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Coupon Amount: </label>
              <label>{{ $orderDetails['coupon_amount'] }} <span style="font-size: .75rem; color:black;">&#x20b4;</span></label>
            </div>
            @endif
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Payment Method: </label>
              <label>{{ $orderDetails['payment_method'] }}</label>
            </div>
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Payment Gateway: </label>
              <label>{{ $orderDetails['payment_gateway'] }}</label>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Customer Details</h4>
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Name: </label>
              <label>{{ $userDetails['name'] }}</label>
            </div>
            @if (!empty($userDetails['address']))
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Address: </label>
              <label>{{ $userDetails['address'] }}</label>
            </div>
            @endif
            @if (!empty($userDetails['city']))
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">City: </label>
              <label>{{ $userDetails['city'] }}</label>
            </div>
            @endif
            @if (!empty($userDetails['state']))
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">State: </label>
              <label>{{ $userDetails['state'] }}</label>
            </div>
            @endif
            @if (!empty($userDetails['country']))
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Country: </label>
              <label>{{ $userDetails['country'] }}</label>
            </div>
            @endif
            @if (!empty($userDetails['pincode']))
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Pincode: </label>
              <label>{{ $userDetails['pincode'] }}</label>
            </div>
            @endif
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Mobile: </label>
              <label>{{ $userDetails['mobile'] }}</label>
            </div>
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Email: </label>
              <label>{{ $userDetails['email'] }}</label>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Delivery Address</h4>
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Name: </label>
              <label>{{ $orderDetails['name'] }}</label>
            </div>
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Address: </label>
              <label>{{ $orderDetails['address'] }}</label>
            </div>
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">City: </label>
              <label>{{ $orderDetails['city'] }}</label>
            </div>
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">State: </label>
              <label>{{ $orderDetails['state'] }}</label>
            </div>
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Country: </label>
              <label>{{ $orderDetails['country'] }}</label>
            </div>
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Pincode: </label>
              <label>{{ $orderDetails['pincode'] }}</label>
            </div>
            <div style="height: 1rem" class="form-group">
              <label class="font-weight-500">Mobile: </label>
              <label>{{ $orderDetails['mobile'] }}</label>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Update Order Status</h4>
            @if (Auth::guard('admin')->user()->type != "vendor")
              <form action="{{ url('admin/update-order-status') }}" method="post">@csrf
                <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                <select name="order_status" id="order_status" required>
                  <option class="d-none" value="" selected>Select</option>
                  @foreach ($orderStatuses as $status)
                    <option 
                      value="{{ $status['name'] }}" 
                      @if (!empty($orderDetails['order_status']) && $orderDetails['order_status'] == $status['name'])
                        selected
                      @endif
                    >
                      {{ $status['name'] }}
                    </option>
                  @endforeach
                </select>

                <input type="text" style="width: 145px; height: 25px;" name="courier_name" id="courier_name" placeholder="Courier Name">

                <input type="text" style="width: 145px; height: 25px;" name="tracking_number" id="tracking_number" placeholder="Tracking Number">
                
                <button type="submit" class="mt-2">Update</button>
              </form>
              <br>
              @foreach ($orderLog as $key => $log)
              {{-- @php
                echo "<pre>"; print_r($log['orders_products'][$key]['product_code']); die;
              @endphp --}}
                <strong>{{ $log['order_status'] }}</strong> :&nbsp;{{ date('Y-m-d h:i:s', strtotime($log['created_at'])) }}
                
                  @if (isset($log['order_item_id']) && $log['order_item_id'] != 0)

                    @php
                      $getItemOrderDetails = OrdersLog::getItemOrderDetails($log['order_item_id']);
                    @endphp

                    - for item: {{ $getItemOrderDetails['product_code'] }}
                    @if (!empty($getItemOrderDetails['courier_name']))
                      <br><span>Courier Name: {{ $getItemOrderDetails['courier_name'] }}</span>
                    @endif
                    @if (!empty($getItemOrderDetails['tracking_number']))
                      <br><span>Tracking Number: {{ $getItemOrderDetails['tracking_number'] }}</span>
                    @endif
                  @endif
                
                <br><hr>
              @endforeach
            @else
              This feature is restricted.
            @endif
          </div>
        </div>
      </div>
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Ordered Products</h4>
            <table class="table table-striped table-dark mt-5">
              <thead>
                <tr align="center">
                  <th colspan="8">
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
                  <th>Item Status</th>
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
                      <img style="transform: scale(1,2); width: 80px; margin-top: 1rem" src="{{ asset('front/images/product_images/small/'.$getProductImage) }}" alt="Product image">
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
                  <td>
                    <form action="{{ url('admin/update-order-item-status') }}" method="post">@csrf
                      <input type="hidden" name="order_item_id" value="{{ $product['id'] }}">
                      <select name="order_item_status" id="order_item_status" required>
                        <option class="d-none" value="">Select</option>
                        @foreach ($orderItemStatuses as $status)
                          <option 
                            value="{{ $status['name'] }}" 
                            @if (!empty($product['item_status']) && $product['item_status'] == $status['name'])
                              selected
                            @endif
                          >
                            {{ $status['name'] }}
                          </option>
                        @endforeach
                      </select>
                      <button type="submit">Update</button>
                      <br>
                      <input type="text" 
                        style="width: 145px; height: 25px;" name="item_courier_name" id="item_courier_name" placeholder="Courier Name"
                        @if (!empty($product['courier_name']))
                          value="{{ $product['courier_name'] }}"
                        @endif
                      >
                      <br>
                      <input type="text" 
                        style="width: 145px; height: 25px;" name="item_tracking_number" id="item_tracking_number" placeholder="Tracking Number"
                        @if (!empty($product['tracking_number']))
                          value="{{ $product['tracking_number'] }}"
                        @endif
                      >

                    </form>
                  </td>
                </tr> 
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- content-wrapper ends -->
  <!-- partial:partials/_footer.html -->
  @include('admin.layouts.footer')
  <!-- partial -->
</div>
@endsection