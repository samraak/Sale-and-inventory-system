<x-app-layout>
    <x-slot name="header">
        Create Unit
    </x-slot>

    <div class="bg-white p-6 rounded shadow-lg max-w-lg mx-auto">
        <h3 class="text-lg font-bold mb-4">Create New Unit</h3>

        <form method="POST" action="{{ route('units.store') }}" class="space-y-4">
            @csrf

            <div>
                <input type="text" name="name" placeholder="Unit Name" required
                       class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <select name="status" class="w-full border p-2 rounded">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                Save Unit
            </button>
        </form>
    </div>
</x-app-layout>