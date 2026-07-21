<x-app-layout>
    <x-slot name="header">
        Create Supplier
    </x-slot>

    <div class="bg-white p-6 rounded shadow-lg max-w-lg mx-auto">
        <h3 class="text-lg font-bold mb-4">Create New Supplier</h3>

        <form method="POST" action="{{ route('suppliers.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Supplier Name</label>
                <input type="text" name="name" placeholder="Supplier Name" required
                       class="w-full border p-2 rounded focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <input type="text" name="phone" placeholder="Phone Number" required
                       class="w-full border p-2 rounded focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CNIC Number</label>
                <input type="text" name="cnic" placeholder="CNIC Number" required
                       class="w-full border p-2 rounded focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <textarea name="address" placeholder="Address" required rows="3"
                          class="w-full border p-2 rounded focus:ring-2 focus:ring-purple-500"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border p-2 rounded">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2 pt-2">
                <a href="{{ route('suppliers.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
                    Cancel
                </a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded transition">
                    Save Supplier
                </button>
            </div>
        </form>
    </div>
</x-app-layout>