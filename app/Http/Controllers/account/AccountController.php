<?php

namespace App\Http\Controllers\account;

use App\Http\Controllers\Controller;
use App\Models\Builder\Order;
use App\Models\Builder\SavedDesign;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    // ── GET /account ───────────────────────────────────────────────────────────
    public function dashboard()
    {
        $user = auth()->user();

        $recentOrders = Order::where('user_id', $user->id)
            ->with(['product', 'design'])
            ->latest()
            ->take(5)
            ->get();

        $savedDesigns = SavedDesign::where('user_id', $user->id)
            ->latest()
            ->take(4)
            ->get();

        $orderCounts = [
            'total'       => Order::where('user_id', $user->id)->count(),
            'pending'     => Order::where('user_id', $user->id)->where('status', 'pending')->count(),
            'in_progress' => Order::where('user_id', $user->id)->whereIn('status', ['confirmed', 'in_progress'])->count(),
            'completed'   => Order::where('user_id', $user->id)->where('status', 'completed')->count(),
        ];

        return view('account.dashboard', compact('user', 'recentOrders', 'savedDesigns', 'orderCounts'));
    }

    // ── GET /account/orders ────────────────────────────────────────────────────
    public function orders(Request $request)
    {
        $user  = auth()->user();
        $query = Order::where('user_id', $user->id)->with(['product', 'design'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('account.orders', compact('orders'));
    }

    // ── GET /account/designs ───────────────────────────────────────────────────
    public function designs()
    {
        $designs = SavedDesign::where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view('account.designs', compact('designs'));
    }

    public function destroyDesign(SavedDesign $design): RedirectResponse
    {
        // Make sure users can only delete their own designs
        abort_if($design->user_id !== auth()->id(), 403);

        if ($design->snapshot_path) {
            Storage::disk('public')->delete($design->snapshot_path);
        }

        $design->delete();

        return back()->with('success', 'Design deleted.');
    }
public function orderShow(string $code)
{
    $order = Order::with(['product', 'design', 'items.element'])
        ->where('order_code', $code)
        ->where('user_id', auth()->id()) // security: only their own orders
        ->firstOrFail();

    return view('account.orders.show', compact('order'));
}

public function approveOrder($code)
{
    // Find the order by its code
    $order = Order::where('order_code', $code)->firstOrFail();

    // Ensure the order belongs to the logged-in user
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }

    // Update the status (assuming you have a status column)
    $order->update([
        'status' => 'approved' // or whatever your status name is
    ]);

    // Redirect back to the order page with a success message
    return redirect()->back()->with('success', 'Order approved successfully! We will start crafting it soon.');
}

}