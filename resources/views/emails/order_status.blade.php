<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <div> 
    <table style="width: 700px;">
      <tr>
        <td><img src="{{ asset('front/images/main-logo/glory_to_ukraine.png') }}" alt="logo"></td>
      </tr>
      <tr>
        <th>Hello {{ $name }}!</th>
      </tr>
      <tr><td>&nbsp;</td></tr>
      <tr>
        <td>Your Order #{{ $order_id }} status has been updated to {{ $order_status }}</td>
      </tr>
      <tr><td>&nbsp;</td></tr>
      <tr>
        <td>Your Order details are as below:</td>
      </tr>
      <tr>
        <table style="width: 95%;" cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
          <thead>
            <tr bgcolor="#ccc">
              <th>Product Name</th>
              <th>Product Code</th>
              <th>Product Size</th>
              <th>Product Color</th>
              <th>Product Quantity</th>
              <th>Product Price</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($orderDetails['orders_products'] as $order)
            <tr bgcolor="#ddd">
              <td>{{ $order['product_name'] }}</td>
              <td>{{ $order['product_code'] }}</td>
              <td>{{ $order['product_size'] }}</td>
              <td>{{ $order['product_color'] }}</td>
              <td>{{ $order['product_qty'] }}</td>
              <td>{{ $order['product_price'] }}</td>
            </tr>
            @endforeach
            <tr><td>&nbsp;</td></tr>
            <tr>
              <th colspan="5" align="right">
                Shipping Charges:
              </th>
              <td>
                {{ $orderDetails['shipping_charges'] }} &#x20b4;
              </td>
            </tr>
            <tr>
              <th colspan="5" align="right">
                Coupon Discount:
              </th>
              <td>
                @if ($orderDetails['coupon_amount'] > 0)
                  {{ $orderDetails['coupon_amount'] }}
                @else
                  0
                @endif
                &#x20b4;
              </td>
            </tr>
            <tr>
              <th colspan="5" align="right">
                Grand Total:
              </th>
              <td>
                {{ $orderDetails['grand_total'] }} &#x20b4;
              </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
          </tbody>
        </table>
      </tr>
      <tr>
        <table>
          <thead>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <th>Delivery Address:</th>
            </tr>
          </thead>
          <tr><td>&nbsp;</td></tr>
          <tbody>
            <tr>
              <th align="left">Name: </th>
              <td>{{ $orderDetails['name'] }}</td>
            </tr>
            <tr>
              <th align="left">Address: </th>
              <td>
                {{ $orderDetails['address'] }}
              </td>
            </tr>
            <tr>
              <th align="left">City: </th>
              <td>
                {{ $orderDetails['city'] }}
              </td>
            </tr>
            <tr>
              <th align="left">State: </th>
              <td>
                {{ $orderDetails['state'] }}
              </td>
            </tr>
            <tr>
              <th align="left">Country: </th>
              <td>
                {{ $orderDetails['country'] }}
              </td>
            </tr>
            <tr>
              <th align="left">Pincode: </th>
              <td>
                {{ $orderDetails['pincode'] }}
              </td>
            </tr>
            <tr>
              <th align="left">Mobile: </th>
              <td>
                {{ $orderDetails['mobile'] }}
              </td>
            </tr>
          </tbody>
        </table>
      </tr>
      <br>
      <tr>
        <td>
          For any queries, you can contact us at 
          <a href="mailto:info@stackdevelopers.in">
            info@stackdevelopers.in
          </a>
        </td>
      </tr>
    </table>
    <p>Thanks & Regards!</p>
    <h4 style="text-align: center;">Multi Vendor Shop</h4>
  </div>
</body>
</html>