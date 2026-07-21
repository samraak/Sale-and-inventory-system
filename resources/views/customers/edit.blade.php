<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Customer
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold text-gray-700 mb-6 border-b pb-3">Update Customer Details</h3>

                <form method="POST" action="{{ route('customers.update', $customer->id) }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Customer Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $customer->name) }}" required 
                               class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" 
                               class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $customer->email) }}" 
                               class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Address</label>
                        <textarea name="address" rows="3" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm">{{ old('address', $customer->address) }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-3 pt-5 border-t border-gray-100 mt-8">
                        <a href="{{ route('customers.index') }}" class="bg-gray-100 text-gray-600 hover:bg-gray-200 px-5 py-2.5 rounded-lg text-sm font-medium transition">
                            Cancel
                        </a>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-bold text-sm shadow-md transition">
                            Update Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>