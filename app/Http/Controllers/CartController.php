<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Produk;
use App\Models\Kategori;

class CartController extends Controller
{
    // Tampilkan cart
    public function index()
    {
        $user = Auth::user();
        $cartItems = $user->cart()->with('produk')->get();
        $total = $cartItems->sum('subtotal');
        $categories = Kategori::all();
        return view('cart.index', compact('cartItems', 'total', 'categories'));
    }

    // Tambah item ke cart
    public function add(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id'
        ]);

        $user = Auth::user();
        $product = Produk::findOrFail($request->produk_id);
        $existingCart = Cart::where('user_id', $user->id)
            ->where('produk_id', $product->id)
            ->first();

        if ($existingCart) {
            $existingCart->update([
                'qty' => $existingCart->qty + '1'
            ]);

            $message = 'Produk berhasil ditambahkan ke keranjang!';
        } else {
            Cart::create([
                'user_id' => $user->id,
                'produk_id' => $product->id,
                'qty' => '1',
                'price' => $product->harga
            ]);

            $message = 'Produk berhasil ditambahkan ke keranjang!';
        }

        return redirect()->back()->with('success', $message);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1|max:99'
        ]);

        try {
            $cart = Cart::with('produk')
                ->where('user_id', Auth::id())
                ->where('id', $id)
                ->firstOrFail();
            $cart->update([
                'qty' => $request->qty
            ]);
            $subtotal = $cart->qty * $cart->price;
            $cartItems = Cart::where('user_id', Auth::id())->get();
            $cartTotal = $cartItems->sum(function ($item) {
                return $item->qty * $item->price;
            });

            $cartCount = $cartItems->sum('qty');

            return response()->json([
                'success' => true,
                'subtotal' => number_format($subtotal, 0, ',', '.'),
                'cart_total' => number_format($cartTotal, 0, ',', '.'),
                'cart_count' => $cartCount,
                'item_id' => $cart->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal update quantity: ' . $e->getMessage()
            ], 500);
        }
    }


    // Hapus item dari cart
    public function remove($id)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $cart->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    // Kosongkan cart
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->back()->with('success', 'Keranjang berhasil dikosongkan!');
    }
}