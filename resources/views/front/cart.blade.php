@extends('layouts.home')

@section('content')
<div class="container">
    <h1>Your Cart</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        @if (count($cart) > 0)
            @foreach ($cart as $item)
                <div class="col-md-4">
                    <div class="card mb-4">
                        @if ($item['image'])
                            <img height="200" width="200" src="{{ asset('storage/' . $item['image']) }}" class="card-img-top" alt="{{ $item['name'] }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item['name'] }}</h5>
                            <p class="card-text">Quantity: {{ $item['quantity'] }}</p>
                            <p class="card-text"><strong>Total: ${{ $item['total_price'] }}</strong></p>
                            <form action="{{ route('cart.remove', ['id' => $item['id']]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <p>Your cart is empty.</p>
            </div>
        @endif
    </div>

    @if (count($cart) > 0)
        <div class="row">
            <div class="col-12">
                <h3>Total Price: ${{ $totalPrice }}</h3>
                <!-- Add a "Proceed to Checkout" button -->
                <a href="{{ route('checkout.index') }}" class="btn btn-primary">Proceed to Checkout</a>
            </div>
        </div>
    @endif
</div>
<script>
document.querySelector('#cart-count-badge').innerText = '{{ $cartItemCount }}';
</script>
@endsection