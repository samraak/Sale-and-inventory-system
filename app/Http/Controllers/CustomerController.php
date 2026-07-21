<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Customer;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    const CUSTOMER_HEAD = 1000;

    // 1. List Page
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('customers.index', compact('customers'));
    }

    // 2. Create Page Form
    public function create()
    {
        return view('customers.create');
    }

    // 3. Store Data
   public function store(Request $request)
{
    $request->validate([
        'name'    => 'required|string|max:255',
        'phone'   => 'nullable|string',
        'email'   => 'nullable|email',
        'address' => 'nullable|string',
    ]);

    DB::transaction(function () use ($request) {

        $customer = Customer::create([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'email'   => $request->email,
            'address' => $request->address,
        ]);

        // COA part (same as your code)
        $baseHead = self::CUSTOMER_HEAD;

        $last = ChartOfAccount::where('parent_id', $baseHead)
            ->orderBy('id', 'desc')
            ->first();

        $nextCode = $last
            ? ((int) substr($last->head_code, -3)) + 1
            : 1;

        $headCode = $baseHead . str_pad($nextCode, 3, '0', STR_PAD_LEFT);

        ChartOfAccount::create([
            'head_code'   => $headCode,
            'head_name'   => $customer->name,
            'parent_id'   => $baseHead,
            'level'       => 2,
            'customer_id' => $customer->id,
            'supplier_id' => null,
        ]);

        // ================= EMAIL SEND (ADD THIS) =================
        Mail::raw(
            "New Customer Created:\n\nName: {$customer->name}\nEmail: {$customer->email}\nPhone: {$customer->phone}",
            function ($message) use ($customer) {
                $message->to($customer->email)
                        ->subject('Customer Created Successfully');
            }
        );
    });

    return redirect()->route('customers.index')
        ->with('success', 'Customer Created Successfully!');
}
    // 4. Edit Page Form
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    // 5. Update Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update(
            $request->only(['name', 'phone', 'email', 'address'])
        );

        // ================= COA UPDATE =================
        ChartOfAccount::where('customer_id', $customer->id)
            ->update([
                'head_name' => $customer->name,
            ]);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer Updated Successfully!');
    }

    // 6. Delete Data
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        // ================= DELETE COA =================
        ChartOfAccount::where('customer_id', $customer->id)
            ->delete();

        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer Deleted Successfully!');
    }
    // ================= API CUSTOMER VIEW =================
public function apiIndex()
{
    $customers = Customer::all();

    return response()->json([
        'status' => true,
        'data' => $customers
    ]);
}

// ================= API CUSTOMER ADD =================
public function apiStore(Request $request)
{
    $request->validate([
        'name'    => 'required|string|max:255',
        'phone'   => 'nullable|string',
        'email'   => 'nullable|email',
        'address' => 'nullable|string',
    ]);

    DB::transaction(function () use ($request, &$customer) {

        // Customer Create
        $customer = Customer::create([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'email'   => $request->email,
            'address' => $request->address,
        ]);

        // Auto Head Code
        $baseHead = self::CUSTOMER_HEAD;

        $last = ChartOfAccount::where('parent_id', $baseHead)
            ->orderBy('id', 'desc')
            ->first();

        $nextCode = $last
            ? ((int) substr($last->head_code, -3)) + 1
            : 1;

        $headCode = $baseHead . str_pad($nextCode, 3, '0', STR_PAD_LEFT);

        // COA Entry
        ChartOfAccount::create([
            'head_code'   => $headCode,
            'head_name'   => $customer->name,
            'parent_id'   => $baseHead,
            'level'       => 2,
            'customer_id' => $customer->id,
            'supplier_id' => null,
        ]);
    });

    return response()->json([
        'status' => true,
        'message' => 'Customer Added Successfully',
        'data' => $customer
    ]);
}

// ================= API CUSTOMER EDIT =================
public function apiUpdate(Request $request, $id)
{
    $customer = Customer::find($id);

    if (!$customer) {
        return response()->json([
            'status' => false,
            'message' => 'Customer Not Found'
        ], 404);
    }

    $customer->update([
        'name'    => $request->name,
        'phone'   => $request->phone,
        'email'   => $request->email,
        'address' => $request->address,
    ]);

    // COA Update
    ChartOfAccount::where('customer_id', $customer->id)
        ->update([
            'head_name' => $customer->name,
        ]);

    return response()->json([
        'status' => true,
        'message' => 'Customer Updated Successfully',
        'data' => $customer
    ]);
}
}