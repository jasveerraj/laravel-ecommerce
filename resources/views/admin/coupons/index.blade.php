@extends('layouts.admin')

@section('content')
<div class="container">
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary mb-3 mt-3">Create Coupon</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Discount</th>
                <th>Valid From</th>
                <th>Valid To</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coupons as $coupon)
            <tr>
                <td>{{ $coupon->id }}</td>
                <td>{{ $coupon->code }}</td>
                <td>{{ $coupon->discount }}</td>
                <td>{{ $coupon->valid_from }}</td>
                <td>{{ $coupon->valid_to }}</td>
                <td>
                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
