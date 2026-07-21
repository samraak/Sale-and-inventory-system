<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Purchase Voucher') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-700">Modify Purchase Voucher</h3>
                    <p class="text-sm text-gray-400">From here you are able to modify data.</p>
                </div>

                <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                            <input type="date" name="date" value="{{ $purchase->date }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Voucher No</label>
                            <input type="text" name="purchase_no" value="{{ $purchase->purchase_no }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Supplier</label>
                            <select name="supplier_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 mb-6">
                        <h4 class="text-sm font-bold text-gray-700 mb-3">Product & Pricing Items</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Select Product</label>
                                <select name="items[0][product_id]" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ isset($purchase->product_id) && $purchase->product_id == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} ({{ $product->unit->name ?? 'No Unit' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Quantity</label>
                                <input type="number" name="items[0][qty]" value="{{ $purchase->qty ?? 1 }}" min="1" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Price (Rs.)</label>
                                <input type="number" step="any" name="items[0][price]" value="{{ $purchase->total_amount }}" min="0" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Narration (Optional)</label>
                        <textarea name="narration" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $purchase->narration }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-4 border-t pt-4">
                        <a href="{{ route('purchases.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold shadow-sm transition">
                            Update Voucher
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>