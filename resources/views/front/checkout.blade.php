@extends('layouts.home')

@section('content')
<div class="container">
    <form id="order-form" action="{{ route('order.place') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Personal Details and Payment Details (Left Side) -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">Personal Details</div>
                    <div class="card-body">
                        <!-- Personal details form -->
                            <!-- Input fields for personal details -->
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" required>
                                </div>
                            </div>
                            <div class="card mt-3">
                                <div class="card-header bg-primary text-white">Payment Details</div>
                                <div class="card-body">
                                    <!-- Payment method selection -->
                                    <div class="form-group">
                                        <label class="mr-3">Payment Method:</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card" checked>
                                            <label class="form-check-label" for="credit_card">Credit Card</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                                            <label class="form-check-label" for="paypal">PayPal</label>
                                        </div>
                                    </div>
                                    <!-- Credit card fields -->
                                    <div id="credit_card_fields">
                                        <div class="form-group">
                                            <label for="card_number">Card Number</label>
                                            <input type="text" class="form-control" id="card_number" name="card_number" required>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="expiration_date">Expiration Date</label>
                                                <input type="text" class="form-control" id="expiration_date" name="expiration_date" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="cvv">CVV</label>
                                                <input type="text" class="form-control" id="cvv" name="cvv" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="cardholder_name">Cardholder Name</label>
                                            <input type="text" class="form-control" id="cardholder_name" name="cardholder_name" required>
                                        </div>
                                    </div>
                                    <!-- PayPal fields -->
                                    <div id="paypal_fields" style="display: none;">
                                        <div class="form-group">
                                            <label for="paypal_email">PayPal Email</label>
                                            <input type="email" class="form-control" id="paypal_email" name="paypal_email" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="total_amount" id="totalPrice" value="{{ $totalPrice }}">
                            <input type="hidden" name="coupon" id="appliedCoupon" value="">
                    </div>
                </div>
            </div>
            
            <!-- Cart Details (Right Side) -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">Your Cart</div>
                    <div class="card-body">
                        <!-- Display cart items here -->
                        @if (count($cart) > 0)
                            <ul class="list-group">
                                @foreach ($cart as $item)
                                    <li class="list-group-item">
                                        <!-- Display cart item details -->
                                        <p>{{ $item['name'] }} | <b>Price: </b>{{ $item['total_price'] }} | <b>Qty: </b>{{ $item['quantity'] }}<p>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="mt-3">
                                <form id="applyCouponForm">
                                    <div class="form-group">
                                        <label for="coupon_code">Apply Coupon:</label>
                                        <input type="text" class="form-control" id="coupon_code" name="coupon_code">
                                    </div>
                                    <button type="button" class="btn btn-primary mt-3" style="float: right;" id="applyCouponButton">Apply</button>
                                </form>
                            </div>
                            <!-- Display total price of items -->
                            <p class="mt-3 text-right"><strong>Total Price: <span class="totalPriceShow">{{ $totalPrice }}<span></strong></p>
                            <button type="submit" class="btn btn-success btn-block mt-3">Place Order</button>
                        @else
                            <p>Your cart is empty.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#cart-count-badge').text('{{ $cartItemCount }}');

        $('#applyCouponButton').click(function() {
            var couponCode = $('#coupon_code').val();
            $.ajax({
                url: '{{ route('apply.coupon') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    coupon_code: couponCode
                },
                success: function(response) {
                    if (response.success) {
                        $('#totalPrice').val(response.newTotal);
                        $('.totalPriceShow').text(response.newTotal);
                        $('#appliedCoupon').val(couponCode);
                        alert('Coupon applied successfully!');
                    } else {
                        alert('Invalid coupon code.');
                    }
                }
            });
        });
        
        // Show/hide payment method fields based on selection
        $('input[name="payment_method"]').change(function() {
            if (this.value === 'credit_card') {
                $('#credit_card_fields').show();
                $('#paypal_fields').hide();
                $('#paypal_fields input').prop('disabled', true);
                $('#credit_card_fields input').prop('disabled', false);
            } else if (this.value === 'paypal') {
                $('#credit_card_fields').hide();
                $('#paypal_fields').show();
                $('#credit_card_fields input').prop('disabled', true);
                $('#paypal_fields input').prop('disabled', false);
            }
        });

        $('#order-form').submit(function() {
            // Enable all inputs before submitting
            $('#credit_card_fields input').prop('disabled', false);
            $('#paypal_fields input').prop('disabled', false);
        });
    });
</script>
@endsection
