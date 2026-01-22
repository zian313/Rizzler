<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Tampilkan cart
    public function index()
    {
        $cart = $this->getCart();
        $cartItems = $cart ? $cart->items()->with('product')->get() : [];
        $totalPrice = $cart ? $cart->getTotalPrice() : 0;
        $totalItems = $cart ? $cart->getTotalItems() : 0;

        return view('cart.index', compact('cart', 'cartItems', 'totalPrice', 'totalItems'));
    }

    // Tambah ke cart
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getOrCreateCart();
        $quantity = $request->quantity;

        // Cek apakah product sudah ada di cart
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Update quantity jika sudah ada
            $cartItem->update([
                'quantity' => $cartItem->quantity + $quantity
            ]);
        } else {
            // Tambah item baru ke cart
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Update quantity item di cart
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui!');
    }

    // Hapus item dari cart
    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    // Kosongkan cart
    public function clear()
    {
        $cart = $this->getCart();
        if ($cart) {
            $cart->items()->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan!');
    }

    // Checkout - dari cart ke order dengan WhatsApp integration
    public function checkout(Request $request)
    {
        $cart = $this->getCart();

        if (!$cart || $cart->items()->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
        ]);

        // Buat order baru
        $totalPrice = $cart->getTotalPrice();
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total_price' => $totalPrice,
            'shipping_address' => $request->shipping_address,
            'phone' => $request->phone,
        ]);

        // Pindahkan items dari cart ke order_items
        $orderDetails = "Pesanan #" . $order->id . ":\n\n";
        foreach ($cart->items as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);
            
            // Build order details untuk WhatsApp
            $orderDetails .= "- " . $cartItem->product->name . "\n";
            $orderDetails .= "  Qty: " . $cartItem->quantity . " x Rp " . number_format($cartItem->product->price, 0, ',', '.') . "\n";
            $orderDetails .= "  Subtotal: Rp " . number_format($cartItem->quantity * $cartItem->product->price, 0, ',', '.') . "\n\n";
        }

        // Tambah info pengiriman
        $orderDetails .= "Alamat: " . $request->shipping_address . "\n";
        $orderDetails .= "No HP: " . $request->phone . "\n";
        $orderDetails .= "Total: Rp " . number_format($totalPrice, 0, ',', '.') . "\n";

        // Kosongkan cart
        $cart->items()->delete();

        // Buat WhatsApp message dan redirect
        $whatsappNumber = '083844492691';
        $message = urlencode($orderDetails);
        $whatsappUrl = "https://wa.me/" . $whatsappNumber . "?text=" . $message;

        return redirect($whatsappUrl)->with('success', 'Order berhasil dibuat! Silakan lanjutkan pembelian di WhatsApp.');
    }

    // Helper: Get atau Create Cart
    private function getOrCreateCart()
    {
        if (auth()->check()) {
            // Jika user login
            $cart = Cart::where('user_id', auth()->id())->first();
            if (!$cart) {
                $cart = Cart::create(['user_id' => auth()->id()]);
            }
        } else {
            // Jika guest user, gunakan session
            $sessionId = session()->getId();
            $cart = Cart::where('session_id', $sessionId)->first();
            if (!$cart) {
                $cart = Cart::create(['session_id' => $sessionId]);
            }
        }
        return $cart;
    }

    // Helper: Get Cart
    private function getCart()
    {
        if (auth()->check()) {
            return Cart::where('user_id', auth()->id())->first();
        } else {
            return Cart::where('session_id', session()->getId())->first();
        }
    }
}
