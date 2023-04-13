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
                  <a href="index.html">Home</a>
              </li>
              <li class="is-marked">
                  <a href="#">Proceed to Payment</a>
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
      <div class="col-lg-12" align="center">
        <h3>PLEASE MAKE PAYMENT FOR YOUR ORDER!</h3>
        <p>Your order number is <strong>{{ Session::get('order_id') }}</strong> and Grand total is <strong>{{ Session::get('grand_total') }}</strong></p>
        <form action="{{ route('payment') }}" method="post">@csrf
          <input type="hidden" name="amount" value="{{ round(Session::get('grand_total') / 36.95, 2) }}">

            <input type="image" src="https://www.paypalobjects.com/digitalassets/c/website/marketing/apac/C2/logos-buttons/44_Yellow_CheckOut_Pill_Button.png"/>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Cart-Page /- -->
@endsection