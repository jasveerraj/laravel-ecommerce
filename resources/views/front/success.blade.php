@extends('layouts.home')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Order Success</div>

                    <div class="card-body">
                        <p>Your order has been successfully placed!</p>
                        <p>{{ $orderId }}</p>
                        <p>Thank you for shopping with us.</p>
                        <!-- You can include additional information or instructions here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
