<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the units.
     */
    public function index()
    {
        // All units arrange in sequence of latest created first
        $units = Unit::latest()->get();
        return view('units.index', compact('units'));
    }

    /**
     * Show the form for creating a new unit.
     */
    public function create()
    {
        return view('units.create');
    }

    /**
     * Store a newly created unit in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name',
        ]);

        Unit::create([
            'name' => $request->name,
        ]);

        return redirect()->route('units.index')
                         ->with('success', 'Unit Created Successfully!');
    }

    /**
     * Show the form for editing the specified unit.
     */
   public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        return view('units.edit', compact('unit'));
    }

    /**
     * Update the specified unit in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Validation mein status ko add kiya (required aur boolean/integer check ke sath)
        $request->validate([
            'name'   => 'required|string|max:255|unique:units,name,' . $id,
            'status' => 'required|in:active,inactive', // Agar 0 aur 1 use kar rahe hain to 'required|boolean' ya 'required|integer' kar dein
        ]);

        $unit = Unit::findOrFail($id);
        
        // 2. Update array mein status ko map kar diya
        $unit->update([
            'name'   => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('units.index')
                         ->with('success', 'Unit Updated Successfully!');
    }
    /**
     * Remove the specified unit from storage.
     */
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        
     
        if ($unit->products && $unit->products()->count() > 0) {
            return redirect()->route('units.index')
                             ->with('error', 'Yeh Unit delete nahi ho sakti kyunki yeh products ke sath linked hai!');
        }

        $unit->delete();

        return redirect()->route('units.index')
                         ->with('success', 'Unit Deleted Successfully!');
    }
}