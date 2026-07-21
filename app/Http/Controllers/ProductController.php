<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Unit;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['supplier', 'unit'])->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $units = Unit::where('status', 1)->get();
        $suppliers = Supplier::where('status', 1)->get();
        return view('products.create', compact('units', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
            'unit_id'     => 'required|exists:units,id',
            'status'      => 'required|in:1,0'
        ]);

        // Naye product ka stock shuru mein hamesha 0 hota hai
        $validated['quantity'] = 0; 

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $units = Unit::where('status', 1)->get();
        $suppliers = Supplier::where('status', 1)->get();
        return view('products.edit', compact('product', 'units', 'suppliers'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
            'unit_id'     => 'required|exists:units,id',
            'status'      => 'required|in:1,0',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
   
}