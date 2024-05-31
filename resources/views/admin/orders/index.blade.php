<!-- resources/views/admin/orders/index.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>All Orders</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Total Amount</th>
                <th>Date</th>
                <th>Status</th>
                <th>View</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->total_amount }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                    <select class="form-control status-dropdown" data-order-id="{{ $order->id }}">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="inprocess" {{ $order->status == 'inprocess' ? 'selected' : '' }}>In Process</option>
                        <option value="dispatched" {{ $order->status == 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                    </td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#orderDetailsModal" data-order-id="{{ $order->id }}">View Details</button>
                        </td>
                    </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Order details will be loaded here via AJAX -->
                <div id="order-details-content"></div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {

    $('.status-dropdown').change(function() {
        var orderId = $(this).data('order-id');
        var status = $(this).val();

        $.ajax({
            url: '/admin/orders/' + orderId + '/status',
            type: 'PATCH',
            data: {
                status: status,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert('Order status updated successfully');
            },
            error: function(xhr) {
                alert('Error updating order status');
            }
        });
    });

    $('#orderDetailsModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var orderId = button.data('order-id');

        // Fetch order details via AJAX
        $.ajax({
            url: "{{ route('admin.orders.show', '') }}/" + orderId,
            method: 'GET',
            success: function(order) {
                var modal = $('#orderDetailsModal');
                var content = `
                    <div class="container-fluid">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Order ID:</strong> ${order.order_id}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Customer Name:</strong> ${order.name}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Total Price:</strong> ${order.total_amount}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Order Date:</strong> ${order.created_at}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Coupon:</strong> ${order.coupon ?? 'NA'}</p>
                            </div>
                        </div>
                        <h5>Cart Items</h5>
                        <ul class="list-group mt-3">`;
                order.order_items.forEach(function(item) {
                    content += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>${item.product.name}</strong>
                                <div class="small text-muted">Quantity: ${item.quantity}</div>
                            </div>
                            <span class="badge badge-primary badge-pill">${item.total_price}</span>
                        </li>`;
                });
                content += `
                        </ul>
                    </div>`;
                $('#order-details-content').html(content);
            },
            error: function() {
                $('#order-details-content').html('<p>An error occurred while fetching order details.</p>');
            }
        });
    });
});
</script>

@endsection
