<?php use App\Models\Product; ?>

<!-- Products-List-Wrapper -->
<div class="table-wrapper u-s-m-b-60">
    <table>@csrf
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $total_price = 0; ?>
            @foreach ($getCartItems as $item)
                @php
                    $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                @endphp
                <tr>
                    <td>
                    <div class="cart-anchor-image">
                        <a href="{{ url('product/'.$item['product_id']) }}">
                        <img src="{{ asset('front/images/product_images/small/'.$item['product']['product_image']) }}" alt="Product">
                        <h6>
                            {{ $item['product']['product_name'] }}({{ $item['product']['product_code'] }}) - {{ $item['size'] }}<br>
                            Color: {{ $item['product']['product_color'] }}
                        </h6>
                        </a>
                    </div>
                    </td>
                    <td>
                    <div class="cart-price list-group">
                        @if ($getDiscountAttributePrice['discount'] > 0)
                        <div class="item-new-price">
                            {{ $getDiscountAttributePrice['final_price'] }}&nbsp;<span style="font-size: .875rem; color:black;">&#x20b4;</span>
                        </div>
                        <div class="item-old-price">
                            {{ $getDiscountAttributePrice['product_price'] }}&nbsp;<span style="font-size: .875rem; color:black;">&#x20b4;</span>
                        </div>
                        @else
                        <div class="item-new-price">
                            {{ $getDiscountAttributePrice['product_price'] }}&nbsp;<span style="font-size: .875rem; color:black;">&#x20b4;</span>
                        </div>
                        @endif
                    </div>
                    </td>
                    <td>
                    <div class="cart-quantity">
                        <div class="quantity">
                        <input type="text" class="quantity-text-field" value="{{ $item['quantity'] }}">
                        <a class="plus-a updateCartItem" data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}" data-max="1000">&#43;</a>
                        <a class="minus-a updateCartItem" data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}" data-min="1">&#45;</a>
                        </div>
                    </div>
                    </td>
                    <td>
                    <div class="cart-price">
                        {{ $getDiscountAttributePrice['final_price'] * $item['quantity'] }}&nbsp;<span style="font-size: .675rem; color:black;">&#x20b4;</span>
                    </div>
                    </td>
                    <td>
                        <div class="action-wrapper">
                            {{-- <button class="button button-outline-secondary fas fa-sync"></button> --}}
                            <button class="button button-outline-secondary fas fa-trash deleteCartItem" data-cartid="{{ $item['id'] }}"></button>
                        </div>
                    </td>
                </tr>
            <?php $total_price += $getDiscountAttributePrice['final_price'] * $item['quantity']; ?>
            @endforeach
            <?php Session::put('total_price', $total_price); ?>
        </tbody>
    </table>
</div>
<!-- Products-List-Wrapper /- -->
