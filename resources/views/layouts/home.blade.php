<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ecommerce')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
/* CSS for dropdown cart */
.dropdown-menu {
    max-height: 300px; /* Set a maximum height for the dropdown */
    overflow-y: auto; /* Enable vertical scrolling when content exceeds the height */
    right: 0; /* Align the dropdown to the right */
    left: auto; /* Reset left position */
}

/* Optional: Adjust padding and margins for better styling */
.dropdown-menu li {
    padding: 10px;
    margin-bottom: 5px;
    border-bottom: 1px solid #ddd;
}
</style>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Ecommerce</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <!-- Add more navigation items here -->
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="nav-link" aria-current="page" href="{{ route('cart.index') }}">
                            Cart <span id="cart-count-badge" class="badge bg-secondary">0</span>
                        </a>    
                        <!-- <a class="nav-link dropdown-toggle" href="#" role="button" id="cartDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Cart <span id="cart-count-badge" class="badge bg-secondary">0</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="cartDropdown">
                            <li><a class="dropdown-item" href="#" id="checkoutBtn">Checkout</a></li>
                        </ul> -->
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">
    @yield('content')
</div>

<!-- Bootstrap Bundle (Bootstrap + Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Your custom JavaScript code can be added here -->

</body>
<script>
// Function to update the cart dropdown
function updateCartDropdown() {
    var dropdownMenu = document.querySelector('.dropdown-menu');
    dropdownMenu.innerHTML = ''; // Clear existing items
    // Make AJAX call to fetch cart data
    $.ajax({
        url: '{{ route('cart.data') }}',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var cartItems = response.cartItems;
            var totalAmount = response.totalAmount;
            if (cartItems && Object.keys(cartItems).length > 0) {
                Object.keys(cartItems).forEach(function(key) {
                    var item = cartItems[key];
                    var listItem = document.createElement('li');
                    listItem.innerHTML = `
                        <span>${item.name} - ${item.price}</span>
                        <span>Quantity: ${item.quantity}</span>
                    `;
                    dropdownMenu.appendChild(listItem);
                });
                // Add total amount to dropdown
                var totalItem = document.createElement('li');
                totalItem.innerHTML = `<span>Total: $${totalAmount}</span>`;
                dropdownMenu.appendChild(totalItem);
            } else {
                // If cart items are empty
                var emptyCartItem = document.createElement('li');
                emptyCartItem.textContent = 'Your cart is empty';
                dropdownMenu.appendChild(emptyCartItem);
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}


// document.querySelector('.nav-link.dropdown-toggle').addEventListener('click', function(event) {
//     event.preventDefault(); 
//     updateCartDropdown(); 
// });

// Handle checkout button click
// document.getElementById('checkoutBtn').addEventListener('click', function(event) {

// });

</script>
</html>
