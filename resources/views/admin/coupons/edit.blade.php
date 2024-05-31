@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Coupon</h1>
    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code" name="code" value="{{ $coupon->code }}" required>
        </div>
        <div class="form-group">
            <label for="discount">Discount</label>
            <input type="text" class="form-control" id="discount" name="discount" value="{{ $coupon->discount }}" required>
        </div>
        <div class="form-group">
            <label for="valid_from">Valid From</label>
            <input type="date" class="form-control" id="valid_from" name="valid_from" value="{{ $coupon->valid_from }}" required>
        </div>
        <div class="form-group">
            <label for="valid_to">Valid To</label>
            <input type="date" class="form-control" id="valid_to" name="valid_to" value="{{ $coupon->valid_to }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update Coupon</button>
    </form>
</div>
@endsection
