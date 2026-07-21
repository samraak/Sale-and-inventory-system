<x-app-layout>
    <x-slot name="header">Suppliers List</x-slot>

    <div class="bg-white p-6 rounded shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-700">Manage Suppliers</h3>
            <a href="{{ route('suppliers.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded shadow transition">
                + Add Supplier
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
                        <th class="p-3 border">Name</th>
                        <th class="p-3 border">Phone</th>
                        <th class="p-3 border">CNIC</th>
                        <th class="p-3 border">Address</th>
                        <th class="p-3 border">Status</th>
                        <th class="p-3 border text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border">{{ $loop->iteration }}</td>
                            <td class="p-3 border font-medium">{{ $supplier->name }}</td>
                            <td class="p-3 border">{{ $supplier->phone }}</td>
                            <td class="p-3 border">{{ $supplier->cnic }}</td>
                            <td class="p-3 border max-w-xs truncate">{{ $supplier->address }}</td>
                            <td class="p-3 border">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $supplier->status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $supplier->status }}
                                </span>
                            </td>
                            <td class="p-3 border text-center space-x-2">
                                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="text-purple-600 hover:underline font-semibold">Edit</a>
                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Do you want to delete this supplier?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline font-semibold">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center p-6 text-gray-400">No record found yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>