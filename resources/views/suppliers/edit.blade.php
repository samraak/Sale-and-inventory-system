<x-app-layout>
    <x-slot name="header">Edit Supplier</x-slot>

    <div class="bg-white p-6 rounded shadow-lg max-w-lg mx-auto">
        <h3 class="text-lg font-bold mb-4 text-gray-700">Update Supplier Details</h3>

        <form method="POST" action="{{ route('suppliers.update', $supplier->id) }}" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Supplier Name</label>
                <input type="text" name="name" value="{{ old('name', $supplier->name) }}" required class="w-full border p-2 rounded focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}" required class="w-full border p-2 rounded focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CNIC Number</label>
                <input type="text" name="cnic" value="{{ old('cnic', $supplier->cnic) }}" required class="w-full border p-2 rounded focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <textarea name="address" required rows="3" class="w-full border p-2 rounded focus:ring-2 focus:ring-purple-500">{{ old('address', $supplier->address) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border p-2 rounded">
                    <option value="Active" {{ $supplier->status === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ $supplier->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2 pt-2">
                <a href="{{ route('suppliers.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">Cancel</a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded transition">Update Supplier</button>
            </div>
        </form>
    </div>
</x-app-layout>