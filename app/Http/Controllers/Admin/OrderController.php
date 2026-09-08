<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;

class OrderController extends Controller
{   
public function invoice($id)
{
    $order = CustomerOrder::with('items.product')->findOrFail($id);

    $pdf = Pdf::loadView('admin.orders.invoice', compact('order'))
        ->setPaper('a4', 'portrait');

    return $pdf->download('invoice-' . $order->order_number . '.pdf');
}
public function invoiceList()
{
    $orders = CustomerOrder::latest()->paginate(10);

    return view('admin.invoices.index', compact('orders'));
}
public function ordersTable()
{
    $orders = CustomerOrder::latest()->paginate(10);

    return view('admin.orders.table', compact('orders'));
}
    /**
     * Display all orders
     */
    public function index()
    {
        $orders = CustomerOrder::with('items')
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,delivered,returned',
        ]);

        $order = CustomerOrder::findOrFail($id);

        $order->status = $request->status;

        $order->save();

        return redirect()
            ->back()
            ->with('success', 'Order status updated successfully.');
    }

    /**
     * Delete order
     */
    public function destroy($id)
    {
        $order = CustomerOrder::findOrFail($id);

        $order->items()->delete();

        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }

public function detail($order_number)
{
    $order = CustomerOrder::with(['items.product', 'customer'])
                ->where('order_number', $order_number)
                ->first();

    if (!$order) {
        return redirect()->route('admin.orders.index')
                         ->with('error', "Order #{$order_number} not found.");
    }

    return view('admin.orders.details', compact('order'));
}

public function show($order_number)
{
    $order = CustomerOrder::with('items')
        ->where('order_number', $order_number)
        ->firstOrFail();

    return view('admin.orders.show', compact('order'));
}
/**
 * Display Order Requests
 */
public function requests()
{
    $requests = CustomerOrder::with(['items.product'])   // Only load existing relationships
        ->latest()
        ->paginate(15);

    return view('admin.orders.requests', compact('requests'));
}
}