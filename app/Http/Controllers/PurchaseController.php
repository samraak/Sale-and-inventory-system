<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Stock;
use App\Models\Product;
use App\Models\PurchaseDetail;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseController extends Controller
{
    public function dashboard()
    {
        return view('dashboard', [
            'totalProducts'   => Product::count(),
            'totalPurchases'  => Purchase::count(),
            'totalSuppliers'  => Supplier::count(),
            'totalUnits'      => Unit::count(),
            'recentPurchases' => Purchase::with('supplier')->latest()->take(5)->get(),
        ]);
    }

    public function index(Request $request)
    {
        $query = Purchase::with('supplier');

        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('purchase_no', 'LIKE', "%{$search}%")
                  ->orWhere('narration', 'LIKE', "%{$search}%")
                  ->orWhereHas('supplier', function ($sq) use ($search) {
                      $sq->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        return view('purchases.index', [
            'purchases' => $query->latest()->paginate(10)
        ]);
    }

    public function create()
    {
        return view('purchases.create', [
            'suppliers' => Supplier::all(),
            'products'  => Product::all(),
        ]);
    }

 public function store(Request $request)
{
    $request->validate([
        'date'        => 'required|date',
        'purchase_no' => 'required|unique:purchases,purchase_no',
        'supplier_id' => 'required|exists:suppliers,id',
        'items'       => 'required|array|min:1',
    ]);

    DB::transaction(function () use ($request) {

        // ================= PURCHASE MASTER =================
        $purchase = Purchase::create([
            'date'         => $request->date,
            'purchase_no'  => $request->purchase_no,
            'supplier_id'  => $request->supplier_id,
            'narration'    => $request->narration,
            'total_amount' => 0,
        ]);

        $grandTotal = 0;

        // ================= ITEMS =================
        foreach ($request->items as $item) {

            $qty   = (int) $item['qty'];
            $price = (float) $item['price'];

            $subtotal = $qty * $price;
            $grandTotal += $subtotal;

            $detail = PurchaseDetail::create([
                'purchase_id' => $purchase->id,
                'product_id'  => $item['product_id'],
                'quantity'    => $qty,
                'unit_price'  => $price,
                'subtotal'    => $subtotal,
            ]);

            Stock::create([
                'product_id'        => $item['product_id'],
                'quantity'          => $qty,
                'unit_price'        => $price,
                'purchase_id'       => $purchase->id,
                'purchasedetail_id' => $detail->id,
                'date'              => $request->date,
                'updated_stock'     => $qty,
                'supplier_id'       => $request->supplier_id,
                'process'           => 'PURCHASE',
            ]);
        }

        // update total
        $purchase->update([
            'total_amount' => $grandTotal
        ]);

        // ================= COA ACCOUNTS =================

        // Inventory account (FIXED HEAD from COA)
        $inventoryCOA = \App\Models\ChartOfAccount::where('head_code', '4001')->first();

        // Supplier account (dynamic)
        $supplierCOA = \App\Models\ChartOfAccount::where('supplier_id', $request->supplier_id)->first();

        if (!$inventoryCOA || !$supplierCOA) {
            throw new \Exception("COA accounts missing (Inventory or Supplier)");
        }

        // ================= TRANSACTION MASTER =================
        $transaction = Transaction::create([
            'date' => $purchase->date,
            'transaction_type' => 'PURCHASE',
            'transaction_type_id' => $purchase->id,
            'voucher_no' => $purchase->purchase_no,
            'narration' => $purchase->narration,
            'total_amount' => $grandTotal,
        ]);

        // ================= TRANSACTION DETAIL =================

        // 1. INVENTORY (DEBIT)
        TransactionDetail::create([
            'date' => $purchase->date,
            'transaction_id' => $transaction->id,
            'narration' => 'Purchase',
            'head_code' => $inventoryCOA->head_code,
            'debit' => $grandTotal,
            'credit' => 0,
        ]);

        // 2. SUPPLIER (CREDIT)
        TransactionDetail::create([
            'date' => $purchase->date,
            'transaction_id' => $transaction->id,
            'head_code' => $supplierCOA->head_code,
            'narration' => 'Purchase',
            'debit' => 0,
            'credit' => $grandTotal,
        ]);

    });

    return redirect()->route('purchases.index')
        ->with('success', 'Purchase saved successfully!');
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'date'        => 'required|date',
            'purchase_no' => "required|unique:purchases,purchase_no,$id",
            'supplier_id' => 'required|exists:suppliers,id',
            'items'       => 'required|array|min:1',
        ]);

        DB::transaction(function () use ($request, $id) {

            $purchase = Purchase::findOrFail($id);

            Stock::where('purchase_id', $purchase->id)->delete();
            PurchaseDetail::where('purchase_id', $purchase->id)->delete();

            $purchase->update([
                'date'        => $request->date,
                'purchase_no' => $request->purchase_no,
                'supplier_id' => $request->supplier_id,
                'narration'   => $request->narration,
            ]);

            $total = 0;

            foreach ($request->items as $item) {

                $qty   = (int) $item['qty'];
                $price = (float) $item['price'];

                $subtotal = $qty * $price;
                $total += $subtotal;

                $detail = PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
                    'product_id'  => $item['product_id'],
                    'quantity'    => $qty,
                    'unit_price'  => $price,
                    'subtotal'    => $subtotal,
                ]);

                Stock::create([
                    'product_id'        => $item['product_id'],
                    'quantity'          => $qty,
                    'unit_price'        => $price,
                    'purchase_id'       => $purchase->id,
                    'purchasedetail_id' => $detail->id,
                    'date'              => $request->date,
                    'updated_stock'     => $qty,
                    'supplier_id'       => $request->supplier_id,
                    'process'           => 'PURCHASE',
                ]);
            }

            $purchase->update(['total_amount' => $total]);
        });

        return redirect()->route('purchases.index')
            ->with('success', 'Purchase updated successfully!');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {

            $purchase = Purchase::findOrFail($id);

            Stock::where('purchase_id', $purchase->id)->delete();
            PurchaseDetail::where('purchase_id', $purchase->id)->delete();

            $purchase->delete();
        });

        return redirect()->route('purchases.index')
            ->with('success', 'Purchase deleted successfully!');
    }

    public function downloadPdf($id)
    {
        $purchase = Purchase::with(['supplier', 'details.product'])->findOrFail($id);

        $pdf = Pdf::loadView('purchases.pdf_invoice', compact('purchase'));

        return $pdf->download('purchase-' . $purchase->purchase_no . '.pdf');
    }
}