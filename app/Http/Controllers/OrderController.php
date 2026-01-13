<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Tampilkan semua order
    public function index()
    {
        $orders = Order::with('user', 'items')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    // Form untuk membuat order baru
    public function create()
    {
        $users = User::all();
        return view('orders.create', compact('users'));
    }

    // Simpan order baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
            'total_price' => 'required|numeric|min:0',
            'shipping_address' => 'required|string',
            'phone' => 'nullable|string',
        ]);

        Order::create($request->all());

        return redirect()->route('orders.index')->with('success', 'Order berhasil dibuat');
    }

    // Tampilkan detail order
    public function show(Order $order)
    {
        $order->load('user', 'items.product');
        return view('orders.show', compact('order'));
    }

    // Form untuk edit order
    public function edit(Order $order)
    {
        $users = User::all();
        return view('orders.edit', compact('order', 'users'));
    }

    // Update order
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
            'total_price' => 'required|numeric|min:0',
            'shipping_address' => 'required|string',
            'phone' => 'nullable|string',
        ]);

        $order->update($request->all());

        return redirect()->route('orders.index')->with('success', 'Order berhasil diperbarui');
    }

    // Hapus order
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order berhasil dihapus');
    }
}
