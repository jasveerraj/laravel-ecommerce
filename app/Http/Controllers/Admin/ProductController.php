<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }
    
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rule for image upload
        ]);

        // Store the uploaded file
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $productData = $request->except('image');
            $productData['image'] = str_replace('public/', '', $imagePath);
            Product::create($productData);
        }

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product created successfully.');
    }

    public function update(Request $request, Product $product)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rule for image upload
        ]);

        // Update the product data
        $product->update($request->except('image'));

        // Store the uploaded file if a new image is provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $product->image = str_replace('public/', '', $imagePath);
            $product->save();
        }

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
