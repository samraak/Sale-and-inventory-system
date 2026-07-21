<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SupplierController extends Controller
{
    const SUPPLIER_HEAD = 2000;

    // 1. List Page
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

    // 2. Create Page
    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name'    => 'required|string|max:255',
        'phone'   => 'nullable|string',
       
        'address' => 'nullable|string',
        'cnic'    => 'required|string',
        'status'  => 'required',
    ]);

    DB::transaction(function () use ($request) {

        // ================= SUPPLIER CREATE =================
        $supplier = Supplier::create([
            'name'    => $request->name,
            'phone'   => $request->phone,
           
            'address' => $request->address,
            'cnic'    => $request->cnic,
            'status'  => $request->status,
        ]);

        // ================= CHART OF ACCOUNT =================
        $baseHead = 1001; // Supplier parent head

        // Final head code (concatenate logic)
        $headCode = $baseHead . $supplier->id;

        ChartOfAccount::create([
            'head_code'   => $headCode,
            'head_name'   => $supplier->name,
            'parent_id'   => $baseHead,   // IMPORTANT (1001)
            'level'       => 2,
            'supplier_id' => $supplier->id,
            'customer_id' => null,
        ]);
    });

    return redirect()->route('suppliers.index')
        ->with('success', 'Supplier Created Successfully!');
}
    // 6. Delete Data
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        // ================= DELETE COA =================
        ChartOfAccount::where('supplier_id', $supplier->id)
            ->delete();

        $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier Deleted Successfully!');
    }
}