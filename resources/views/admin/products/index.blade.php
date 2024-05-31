@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">Add Product</a>

    @if ($products->isEmpty())
    <p>No products found.</p>
    @else
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>${{ $product->price }}</td>
                    <td>
                        @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100">
                        @else
                        <span>No image</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
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
    @endif
</div>
@endsection
