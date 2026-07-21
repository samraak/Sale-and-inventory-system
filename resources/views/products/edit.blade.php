<x-app-layout>
    <x-slot name="header">Edit Product</x-slot>

    <div class="bg-white p-6 rounded shadow-lg max-w-lg mx-auto">
        <h3 class="text-lg font-bold mb-4 text-gray-700">Update Product Details</h3>

        <form method="POST" action="{{ route('products.update', $product->id) }}" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full border p-2 rounded focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Unit</label>
                <select name="unit_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Unit</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ $product->unit_id == $unit->id ? 'selected' : '' }}>
                            {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border p-2 rounded">
                    <option value="Active" {{ $product->status === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ $product->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2 pt-2">
                <a href="{{ route('products.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">Cancel</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">Update Product</button>
            </div>
        </form>
    </div>
</x-app-layout>