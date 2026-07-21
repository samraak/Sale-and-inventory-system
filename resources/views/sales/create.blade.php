<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Sale Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- VALIDATION ERROR BOX START --}}
            @if ($errors->any())
                <div class="bg-red-600 text-white p-4 rounded-lg mb-6 shadow-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- VALIDATION ERROR BOX END --}}

            <form action="{{ route('sales.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Sale Date</label>
                        <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full border-gray-200 rounded-lg px-4 py-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Voucher No</label>
                        <input type="text" name="voucher_no" value="{{ $voucher_no }}" readonly class="w-full bg-gray-100 border-gray-200 rounded-lg text-red-600 font-mono font-bold px-4 py-2.5 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Select Customer</label>
                        <select name="customer_id" required class="w-full border-gray-200 rounded-lg px-4 py-2.5">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 overflow-hidden">
                    <table class="w-full text-left text-sm border-collapse mb-4" id="sales-table">
                        <thead class="bg-gray-50 text-gray-600 font-semibold border-b border-gray-100">
                            <tr>
                                <th class="p-4 w-1/3">Product</th>
                                <th class="p-4 w-1/6">Quantity</th>
                                <th class="p-4 w-1/6">Unit Price</th>
                                <th class="p-4 w-1/6">Sub Total</th>
                                <th class="p-4 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            <tr class="item-row">
                                <td class="p-4">
                                    <select name="items[0][product_id]" required class="w-full border-gray-200 rounded-lg product-select">
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="p-4">
                                    <input type="number" name="items[0][quantity]" value="1" min="1" required class="w-full border-gray-200 rounded-lg qty-input">
                                </td>
                                <td class="p-4">
                                    <input type="number" name="items[0][sale_price]" value="0" min="0" step="0.01" required class="w-full border-gray-200 rounded-lg price-input">
                                </td>
                                <td class="p-4 font-semibold text-gray-700 subtotal-text pt-7">Rs. 0.00</td>
                                <td class="p-4 text-center"><button type="button" class="text-red-500 remove-row-btn" style="display: none;">&times;</button></td>
                            </tr>
                        </tbody>
                    </table>

                    <button type="button" id="add-row-btn" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-semibold">+ Add More Item</button>

                    <div class="flex justify-end items-center mt-6 pt-4 border-t">
                        <div class="text-right">
                            <span class="text-xs text-gray-400 font-bold uppercase">Grand Total</span>
                            <div class="text-3xl font-extrabold text-green-600">Rs. <span id="grand-total">0.00</span></div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="total_amount" id="total_amount_hidden" value="0">

                <div class="flex justify-end space-x-4">
                    <button type="submit" class="bg-blue-600 text-white px-8 py-2.5 rounded-lg text-sm font-bold">Save Invoice</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            let rowIndex = 1;

            $('#add-row-btn').click(function() {
                let newRow = `<tr class="item-row">
                    <td class="p-4"><select name="items[${rowIndex}][product_id]" required class="w-full border-gray-200 rounded-lg"><option value="">Select Product</option>@foreach($products as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach</select></td>
                    <td class="p-4"><input type="number" name="items[${rowIndex}][quantity]" value="1" min="1" required class="w-full border-gray-200 rounded-lg qty-input"></td>
                    <td class="p-4"><input type="number" name="items[${rowIndex}][sale_price]" value="0" min="0" step="0.01" required class="w-full border-gray-200 rounded-lg price-input"></td>
                    <td class="p-4 subtotal-text">Rs. 0.00</td>
                    <td class="p-4 text-center"><button type="button" class="text-red-500 remove-row-btn">&times;</button></td>
                </tr>`;
                $('#table-body').append(newRow);
                rowIndex++;
            });

            $(document).on('click', '.remove-row-btn', function() {
                $(this).closest('tr').remove();
                calculateGrandTotal();
            });

            $(document).on('input', '.qty-input, .price-input', function() {
                let row = $(this).closest('tr');
                let qty = parseFloat(row.find('.qty-input').val()) || 0;
                let price = parseFloat(row.find('.price-input').val()) || 0;
                row.find('.subtotal-text').text('Rs. ' + (qty * price).toFixed(2));
                calculateGrandTotal();
            });

            function calculateGrandTotal() {
                let grandTotal = 0;
                $('.item-row').each(function() {
                    let qty = parseFloat($(this).find('.qty-input').val()) || 0;
                    let price = parseFloat($(this).find('.price-input').val()) || 0;
                    grandTotal += (qty * price);
                });
                $('#grand-total').text(grandTotal.toFixed(2));
                $('#total_amount_hidden').val(grandTotal.toFixed(2));
            }
        });
    </script>
</x-app-layout>