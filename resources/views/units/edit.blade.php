<x-app-layout>
    <x-slot name="header">Edit Unit</x-slot>

    <div class="bg-white p-6 rounded shadow-lg max-w-lg mx-auto">
        <h3 class="text-lg font-bold mb-4 text-gray-700">Update Unit Details</h3>

        <form method="POST" action="{{ route('units.update', $unit->id) }}" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unit Name</label>
                <input type="text" name="name" value="{{ old('name', $unit->name) }}" required class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border p-2 rounded">
                    <option value="Active" {{ $unit->status === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ $unit->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2 pt-2">
                <a href="{{ route('units.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">Cancel</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">Update Unit</button>
            </div>
        </form>
    </div>
</x-app-layout>