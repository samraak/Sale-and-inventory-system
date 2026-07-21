<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customers Management') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-end mb-6">
                <a href="{{ route('customers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-md transition-all duration-150">
                    + Add New Customer
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left text-sm border-collapse">
                    <thead class="bg-gray-50 text-gray-600 font-semibold border-b border-gray-100">
                        <tr>
                            <th class="p-4">#</th>
                            <th class="p-4">Customer Name</th>
                            <th class="p-4">Phone</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Address</th>
                            <th class="p-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($customers as $customer)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 align-middle font-mono text-gray-400">{{ $loop->iteration }}</td>
                                <td class="p-4 align-middle font-semibold text-gray-800">{{ $customer->name }}</td>
                                <td class="p-4 align-middle text-gray-600">{{ $customer->phone ?? 'N/A' }}</td>
                                <td class="p-4 align-middle text-gray-600">{{ $customer->email ?? 'N/A' }}</td>
                                <td class="p-4 align-middle text-gray-600">{{ $customer->address ?? 'N/A' }}</td>
                                <td class="p-4 text-center align-middle space-x-2">
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-400">No customers found. Click "+ Add New Customer" to start.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4 border-t border-gray-100">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>