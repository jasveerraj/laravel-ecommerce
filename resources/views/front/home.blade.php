@extends('layouts.home')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4">
                <div class="card mb-4">
                    @if ($product->image)
                        <img height="200" width="200" src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text"><strong>{{ $product->price }}</strong></p>
                        <form>
                            @csrf
                            <button type="submit" class="btn btn-primary add-to-cart-btn" data-product-id="{{ $product->id }}">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
// cart.js

$(document).ready(function() {
    $('#cart-count-badge').text('{{ $cartItemCount }}');
    // Get the CSRF token value from the meta tag
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Handle click event for "Add to Cart" button
    $('.add-to-cart-btn').click(function(event) {
        event.preventDefault();
        var productId = $(this).data('product-id');

        // Send the CSRF token with the request headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        $.ajax({
            type: 'POST',
            url: '/cart/add/' + productId,
            dataType: 'json',
            success: function(response) {
                // Update cart icon with new item count
                $('#cart-count-badge').text(response.cartItemCount);

                // Show popup notification with added item details
                showPopupNotification(response.productName);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // Function to show popup notification
    function showPopupNotification(productName) {
        // Display popup notification with added item details
    }
});


</script>

@endsection
