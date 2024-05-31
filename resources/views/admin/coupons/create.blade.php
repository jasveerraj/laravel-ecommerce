@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Create Coupon</h1>
    <form action="{{ route('admin.coupons.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code" name="code" required>
        </div>
        <div class="form-group">
            <label for="discount">Discount</label>
            <input type="text" class="form-control" id="discount" name="discount" required>
        </div>
        <div class="form-group">
            <label for="valid_from">Valid From</label>
            <input type="date" class="form-control" id="valid_from" name="valid_from" required>
        </div>
        <div class="form-group">
            <label for="valid_to">Valid To</label>
            <input type="date" class="form-control" id="valid_to" name="valid_to" required>
        </div>
        <button type="submit" class="btn btn-success">Create Coupon</button>
    </form>
</div>
@endsection
