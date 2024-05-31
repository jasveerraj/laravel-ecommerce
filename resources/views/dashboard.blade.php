<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <a href="{{ route('admin.orders.index') }}" class="text-blue-500 hover:text-blue-700">
                    <div class="p-6 text-gray-900">
                        <h3>Orders</h3>
                        <strong> {{ $orders->count() }}</strong>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <a href="{{ route('admin.products.index') }}" class="text-blue-500 hover:text-blue-700">
                    <div class="p-6 text-gray-900">
                        <h3>Products</h3>
                        <strong> {{ $products->count() }}</strong>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

