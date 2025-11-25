<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product'])
            ->latest();

        // Apply filters
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('order_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('order_date', '<=', $request->date_to);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('first_name', 'like', "%{$search}%")
                               ->orWhere('last_name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->paginate(10);

        return view('admin.manage_orders', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.order_details', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        $order->update([
            'status' => $newStatus,
            'payment_status' => $request->payment_status
        ]);

        // Update timestamps based on status
        if ($newStatus === 'processing' && $oldStatus !== 'processing') {
            $order->update(['paid_at' => now()]);
        } elseif ($newStatus === 'shipped' && !$order->shipped_at) {
            $order->update(['shipped_at' => now()]);
        } elseif ($newStatus === 'delivered' && !$order->delivered_at) {
            $order->update(['delivered_at' => now()]);
        }

        // Update product stock if order is cancelled
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->orderItems as $item) {
                $product = $item->product;
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }
        }

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function approve(Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be approved.');
        }

        $order->update([
            'status' => 'processing',
            'payment_status' => 'paid',
            'paid_at' => now()
        ]);

        return redirect()->back()->with('success', 'Order approved successfully.');
    }

    public function decline(Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be declined.');
        }

        $order->update([
            'status' => 'cancelled',
            'payment_status' => 'failed'
        ]);

        // Restore product stock
        foreach ($order->orderItems as $item) {
            $product = $item->product;
            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        }

        return redirect()->back()->with('success', 'Order declined successfully.');
    }

    public function updateOrderItem(Request $request, OrderItem $orderItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        $oldQuantity = $orderItem->quantity;
        $newQuantity = $request->quantity;

        $orderItem->update([
            'quantity' => $newQuantity,
            'price' => $request->price
        ]);

        // Update product stock if quantity changed
        if ($oldQuantity !== $newQuantity && $orderItem->product) {
            $stockDifference = $oldQuantity - $newQuantity;
            $orderItem->product->increment('stock', $stockDifference);
        }

        // Recalculate order totals
        $this->recalculateOrderTotals($orderItem->order);

        return redirect()->back()->with('success', 'Order item updated successfully.');
    }

    private function recalculateOrderTotals(Order $order)
    {
        $subtotal = $order->orderItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $order->update([
            'subtotal' => $subtotal,
            'total_amount' => $subtotal + $order->shipping_cost + $order->tax_amount
        ]);
    }

    public function destroy(Order $order)
    {
        try {
            // Restore product stock before deleting
            foreach ($order->orderItems as $item) {
                $product = $item->product;
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }

            $order->orderItems()->delete();
            $order->delete();

            return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting order: ' . $e->getMessage());
        }
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'action' => 'required|in:approve,decline,delete'
        ]);

        $orderIds = $request->order_ids;
        $action = $request->action;

        try {
            foreach ($orderIds as $orderId) {
                $order = Order::find($orderId);

                switch ($action) {
                    case 'approve':
                        if ($order->status === 'pending') {
                            $order->update([
                                'status' => 'processing',
                                'payment_status' => 'paid',
                                'paid_at' => now()
                            ]);
                        }
                        break;

                    case 'decline':
                        if ($order->status === 'pending') {
                            $order->update([
                                'status' => 'cancelled',
                                'payment_status' => 'failed'
                            ]);

                            // Restore product stock
                            foreach ($order->orderItems as $item) {
                                $product = $item->product;
                                if ($product) {
                                    $product->increment('stock', $item->quantity);
                                }
                            }
                        }
                        break;

                    case 'delete':
                        // Restore product stock before deleting
                        foreach ($order->orderItems as $item) {
                            $product = $item->product;
                            if ($product) {
                                $product->increment('stock', $item->quantity);
                            }
                        }
                        $order->orderItems()->delete();
                        $order->delete();
                        break;
                }
            }

            $message = match($action) {
                'approve' => 'Selected orders approved successfully.',
                'decline' => 'Selected orders declined successfully.',
                'delete' => 'Selected orders deleted successfully.',
            };

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error performing bulk action: ' . $e->getMessage());
        }
    }
}