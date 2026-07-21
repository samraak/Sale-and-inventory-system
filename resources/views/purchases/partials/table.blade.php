<table class="w-full text-left border-collapse whitespace-nowrap">
    <thead>
        <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold uppercase tracking-wider text-gray-500">
            <th class="px-6 py-4">Voucher No</th>
            <th class="px-6 py-4">Date</th>
            <th class="px-6 py-4">Supplier</th>
            <th class="px-6 py-4">Total Amount</th>
            <th class="px-6 py-4 text-right">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
        @forelse($purchases as $purchase)
            <tr class="hover:bg-gray-50/70 transition-colors">
                <td class="px-6 py-4 font-semibold text-gray-950">#{{ $purchase->purchase_no }}</td>
                <td class="px-6 py-4 font-medium text-gray-600">{{ $purchase->date }}</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200 uppercase">
                        {{ $purchase->supplier->name ?? 'N/A' }}
                    </span>
                </td>
                <td class="px-6 py-4 font-bold text-gray-900">{{ number_format($purchase->total_amount, 2) }}</td>
                <td class="px-6 py-4 text-right">
                    <div class="inline-flex items-center gap-3 justify-end">
                        
                        <a href="{{ route('purchases.show', $purchase->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-900 transition">
                            View
                        </a>

                        <a href="{{ route('purchases.pdf', $purchase->id) }}" class="text-sm font-medium text-amber-600 hover:text-amber-900 transition">
                            PDF
                        </a>

                        <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this purchase voucher? It will also remove it from stocks.');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-900 transition bg-none border-none cursor-pointer p-0">
                                Delete
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-sm font-medium text-gray-400 bg-gray-50/30">
                    No purchase vouchers found matching the criteria.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@if($purchases->hasPages())
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 pagination">
        {{ $purchases->links() }}
    </div>
@endif