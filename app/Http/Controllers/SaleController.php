<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    public function index()
    {
        return view('sales.index', [
            'sales' => Sale::with(['details.product', 'customer'])
                ->latest()
                ->paginate(10)
        ]);
    }

    public function create()
    {
        $latest = Sale::latest()->first();

        return view('sales.create', [
            'products'   => Product::all(),
            'customers'  => Customer::all(),
            'voucher_no' => $latest
                ? 'SALE-' . str_pad($latest->id + 1, 3, '0', STR_PAD_LEFT)
                : 'SALE-001'
        ]);
    }

  public function store(Request $request)
{
    $request->validate([
        'voucher_no'            => 'required',
        'customer_id'           => 'required|exists:customers,id',
        'date'                  => 'required|date',
        'items'                 => 'required|array|min:1',

        'items.*.product_id'   => 'required|exists:products,id',
        'items.*.quantity'     => 'required|numeric|min:1',
        'items.*.sale_price'   => 'required|numeric|min:0',
    ]);

    DB::transaction(function () use ($request) {

        // ================= SALE MASTER =================
        $sale = Sale::create([
            'voucher_no'   => $request->voucher_no,
            'customer_id'  => $request->customer_id,
            'date'         => $request->date,
            'total_amount' => 0,
        ]);

        $grandTotal = 0;

        foreach ($request->items as $item) {

            $remainingQty = (int) $item['quantity'];

            // ================= GET PURCHASE STOCK (FIFO) =================
            $stocks = Stock::where('product_id', $item['product_id'])
                ->where('process', 'PURCHASE')
                ->where('updated_stock', '>', 0)
                ->orderBy('id', 'asc') // oldest shipment first
                ->lockForUpdate()
                ->get();

            $availableStock = $stocks->sum('updated_stock');
        

            // ================= STOCK CHECK =================
            if ($remainingQty > $availableStock) {
                throw new \Exception(
                    "Not enough stock. Available: $availableStock"
                );
            }

            // ================= FIFO SALE =================
            foreach ($stocks as $stock) {

                if ($remainingQty <= 0) {
                    break;
                }

                // kitna sale karna hai current shipment se
                $sellQty = min(
                    $stock->updated_stock,
                    $remainingQty
                );

                // ================= UPDATE PURCHASE STOCK =================
                $stock->updated_stock =
                    $stock->updated_stock - $sellQty;

                $stock->save();

                // ================= SALE DETAIL =================
                SaleDetail::create([
                    'sale_id'     => $sale->id,
                    'product_id'  => $item['product_id'],
                    'date'        => $sale->date,
                    'quantity'    => $sellQty,

                    // purchase cost price
                    'cost_price'  => $stock->unit_price,

                    // selling price
                    'sale_price'  => $item['sale_price'],

                    'sub_amount'  => $sellQty * $item['sale_price'],

                    // shipment tracking
                    'shipment_id' => $stock->id,
                ]);

                // ================= STOCK SALE ENTRY =================
                Stock::create([
                    'product_id'    => $item['product_id'],
                    'quantity'      => $sellQty,

                    // unit price = sale price
                    'unit_price'    => $item['sale_price'],

                    'process'       => 'SALE',
                    'sale_id'       => $sale->id,

                    // IMPORTANT
                   

                    'date'          => $sale->date,

                    // sale stock always 0
                    'updated_stock' => 0,
                ]);

                // remaining quantity reduce
                $remainingQty -= $sellQty;
            }

            // ================= GRAND TOTAL =================
            $grandTotal += (
                $item['quantity']
                * $item['sale_price']
            );
        }

        // ================= UPDATE SALE TOTAL =================
        $sale->update([
            'total_amount' => $grandTotal
        ]);
    });

    return redirect()
        ->route('sales.index')
        ->with(
            'success',
            'Sale saved successfully!'
        );
}
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $sale = Sale::with('details')->findOrFail($id);

            foreach ($sale->details as $detail) {
                // 🔒 PURCHASE stock wapas restore karo
                $purchaseStock = Stock::lockForUpdate()
                    ->where('id', $detail->shipment_id)  // ✅ Direct integer match
                    ->where('process', 'PURCHASE')
                    ->first();

                if ($purchaseStock) {
                    $purchaseStock->increment('updated_stock', $detail->quantity);
                }

                // SALE transaction logs delete karo
                Stock::where('process', 'SALE')
    ->where('sale_id', $sale->id)
    ->delete();
            }

            // Cleanup
            $sale->details()->delete();
            $sale->delete();
        });

        return redirect()->route('sales.index')
            ->with('success', 'Sale deleted and stock restored successfully!');
    }
}