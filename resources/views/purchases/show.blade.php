<x-app-layout>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-800">Purchase Voucher Details</h1>
    </div>

    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm max-w-4xl">
        
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-700">Voucher #{{ $purchase->purchase_no }}</h2>
            <a href="{{ route('purchases.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition">
                Back to List
            </a>
        </div>

        <div class="space-y-4">
            
            <div class="flex border-b border-gray-100 pb-3">
                <div class="w-1/3 text-sm font-medium text-gray-500">Voucher Date</div>
                <div class="w-2/3 text-sm text-gray-800 font-medium">{{ $purchase->date }}</div>
            </div>

            <div class="flex border-b border-gray-100 pb-3">
                <div class="w-1/3 text-sm font-medium text-gray-500">Supplier Identity</div>
                <div class="w-2/3 text-sm text-gray-800 font-semibold uppercase">
                    ({{ $purchase->supplier_id }}) {{ $purchase->supplier->name ?? 'N/A' }}
                </div>
            </div>

            <div class="flex border-b border-gray-100 pb-3">
                <div class="w-1/3 text-sm font-medium text-gray-500">Total Net Amount</div>
                <div class="w-2/3 text-sm text-gray-900 font-bold">
                    {{ number_format($purchase->total_amount, 2) }}
                </div>
            </div>

            <div class="flex pb-2">
                <div class="w-1/3 text-sm font-medium text-gray-500">Narration / Remarks</div>
                <div class="w-2/3 text-sm text-gray-600 leading-relaxed font-medium">
                    {{ $purchase->narration ?? 'No remarks recorded for this purchase voucher.' }}
                </div>
            </div>

        </div>

    </div>
</x-app-layout>