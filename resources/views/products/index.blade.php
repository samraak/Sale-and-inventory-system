<x-app-layout>
    <x-slot name="header">Products List</x-slot>

    <div class="bg-white p-6 rounded shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-700">Manage Products</h3>
            <a href="{{ route('products.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow transition">
                + Add Product
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4 font-medium">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full border text-left text-sm">
                <thead class="bg-gray-100 text-gray-700 font-bold">
                    <tr>
                        <th class="p-3 border">#</th>
                        <th class="p-3 border">Product Name</th>
                        <th class="p-3 border">Assigned Unit</th>
                        <th class="p-3 border">Status</th>
                        <th class="p-3 border text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border">{{ $loop->iteration }}</td>
                            <td class="p-3 border font-medium">{{ $product->name }}</td>
                            <td class="p-3 border">
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded border text-xs">
                                    {{ $product->unit->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="p-3 border">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $product->status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->status }}
                                </span>
                            </td>
                            <td class="p-3 border text-center space-x-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="text-green-600 hover:underline font-semibold">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Do you want to delete this?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline font-semibold">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-6 text-gray-400">no product yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>