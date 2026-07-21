<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Purchase Voucher
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen" x-data="purchaseForm()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                
                <h3 class="text-xl font-bold text-gray-700 mb-6 border-b pb-3">New Purchase Invoice</h3>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('purchases.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Purchase Date</label>
                            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required 
                                   class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Voucher No</label>
                            <input type="text" name="purchase_no" 
                                   value="{{ old('purchase_no', 'PUR-' . rand(10000, 99999)) }}" 
                                   class="w-full border border-gray-300 p-2.5 rounded-lg font-bold font-mono text-red-600 shadow-sm bg-white">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Select Supplier</label>
                            <select name="supplier_id" required 
                                    class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="border border-gray-100 rounded-xl overflow-hidden mt-8 shadow-sm">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead class="bg-gray-50 text-gray-600 font-semibold border-b border-gray-100">
                                <tr>
                                    <th class="p-4 w-5/12">Product Name</th>
                                    <th class="p-4 w-2/12">Quantity</th>
                                    <th class="p-4 w-2/12">Unit Price (Rs.)</th>
                                    <th class="p-4 w-2/12 text-right">Sub Total</th>
                                    <th class="p-4 w-1/12 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                <template x-for="(item, index) in items" :key="index">
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="p-4">
                                            <select :name="`items[${index}][product_id]`" x-model="item.product_id" required
                                                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                                                <option value="">Select Product</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td class="p-4">
                                            <input type="number" :name="`items[${index}][qty]`" x-model.number="item.qty" min="1" required
                                                   class="w-full border border-gray-300 p-2 rounded-lg text-center focus:ring-2 focus:ring-blue-500">
                                        </td>

                                        <td class="p-4">
                                            <input type="number" :name="`items[${index}][price]`" x-model.number="item.price" min="0" step="0.01" required
                                                   class="w-full border border-gray-300 p-2 rounded-lg text-center focus:ring-2 focus:ring-blue-500">
                                        </td>

                                        <td class="p-4 text-right font-semibold text-gray-700 align-middle">
                                            Rs. <span x-text="(item.qty * item.price).toFixed(2)">0.00</span>
                                        </td>

                                        <td class="p-4 text-center align-middle">
                                            <button type="button" @click="removeItem(index)" :disabled="items.length === 1"
                                                    class="text-red-500 hover:text-red-700 disabled:opacity-30 font-bold text-lg">
                                                &times;
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>

                        <div class="bg-gray-50 p-4 flex flex-col sm:flex-row justify-between items-center border-t border-gray-100 gap-4">
                            <button type="button" @click="addItem()" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-semibold shadow-sm transition">
                                + Add More Item
                            </button>
                            <div class="text-right">
                                <span class="text-gray-500 text-sm font-medium mr-2">Grand Total:</span>
                                <span class="text-xl font-extrabold text-blue-600">Rs. <span x-text="calculateGrandTotal().toFixed(2)">0.00</span></span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Narration (Optional)</label>
                        <textarea name="narration" rows="3" placeholder="Enter voucher remarks..."
                                  class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm">{{ old('narration') }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-3 pt-5 border-t border-gray-100 mt-8">
                        <a href="{{ route('purchases.index') }}" class="bg-gray-100 text-gray-600 hover:bg-gray-200 px-5 py-2.5 rounded-lg text-sm font-medium transition">
                            Cancel
                        </a>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-bold text-sm shadow-md transition">
                            Save Purchase Voucher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function purchaseForm() {
            return {
                items: [
                    { product_id: '', qty: 1, price: 0 }
                ],
                addItem() {
                    this.items.push({ product_id: '', qty: 1, price: 0 });
                },
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },
                calculateGrandTotal() {
                    return this.items.reduce((sum, item) => sum + (parseNumeric(item.qty) * parseNumeric(item.price)), 0);
                }
            }
        }
        function parseNumeric(val) {
            let n = parseFloat(val);
            return isNaN(n) ? 0 : n;
        }
    </script>
</x-app-layout>