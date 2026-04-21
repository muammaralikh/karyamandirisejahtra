<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('produk')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.account.cart.index')->with('error', 'Keranjang belanja kosong');
        }
        $subtotal = $cartItems->sum(function ($item) {
            return $item->qty * $item->price;
        }) + 10000;
        $addresses = $user->addresses()->orderBy('is_primary', 'desc')->get();
        $categories = Kategori::latest()->get();
        return view('cart.checkout', compact(
            'cartItems',
            'categories',
            'subtotal',
            'addresses'
        ));
    }
    public function continue($id)
    {
        $user = Auth::user();
        $order = Order::where('id', $id)
            ->where('user_id', $user->id)
            ->with('produk')
            ->firstOrFail();
        $cartItems = $order->items()->with('product')->get();
        $subtotal = $cartItems->sum(function ($item) {
            return $item->qty * $item->price;
        }) + 10000;
        $addresses = $user->addresses()->orderBy('is_primary', 'desc')->get();
        if ($order->status !== 'pending') {
            return redirect()->route('user.orders.detail', $id)
                ->with('error', 'Pesanan ini sudah diproses atau telah dibayar');
        }

        return view('cart.checkout', compact(
            'cartItems',
            'subtotal',
            'addresses'
        ));
    }
    public function process(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            $cartItems = Cart::where('user_id', $user->id)->with('produk')->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
            }

            foreach ($cartItems as $cartItem) {
                if (!$cartItem->produk) {
                    return redirect()->back()->with('error', 'Ada produk di keranjang yang sudah tidak tersedia.');
                }

                if ($cartItem->qty > $cartItem->produk->stok) {
                    return redirect()->back()->with(
                        'error',
                        "Stok {$cartItem->produk->nama} tidak mencukupi. Tersisa {$cartItem->produk->stok}."
                    );
                }
            }

            $subtotal = $cartItems->sum(function ($item) {
                return $item->qty * $item->price;
            }) + 10000;
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            $address = Address::findOrFail($request->address_id);
            $order = DB::transaction(function () use ($user, $request, $cartItems, $subtotal, $orderNumber, $address) {
                $lockedItems = Cart::where('user_id', $user->id)
                    ->with(['produk' => function ($query) {
                        $query->lockForUpdate();
                    }])
                    ->lockForUpdate()
                    ->get();

                foreach ($lockedItems as $cartItem) {
                    if (!$cartItem->produk) {
                        throw new \RuntimeException('Ada produk di keranjang yang sudah tidak tersedia.');
                    }

                    if ($cartItem->qty > $cartItem->produk->stok) {
                        throw new \RuntimeException(
                            "Stok {$cartItem->produk->nama} tidak mencukupi. Tersisa {$cartItem->produk->stok}."
                        );
                    }
                }

                $order = Order::create([
                    'user_id' => $user->id,
                    'order_number' => $orderNumber,
                    'status' => 'pending',
                    'subtotal' => $subtotal,
                    'shipping_cost' => 10000,
                    'total' => $subtotal,
                    'shipping_method' => 'Ongkir',
                    'payment_method' => 'Transfer Bank',
                    'notes' => $request->notes,
                    'recipient_name' => $address->recipient_name,
                    'recipient_phone' => $address->recipient_phone,
                    'shipping_address' => $address->full_address,
                    'province' => $address->province_name,
                    'city' => $address->city_name,
                    'district' => $address->district_name,
                    'postal_code' => $address->postal_code
                ]);

                foreach ($lockedItems as $cartItem) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->produk_id,
                        'product_name' => $cartItem->produk->nama,
                        'qty' => $cartItem->qty,
                        'price' => $cartItem->price,
                        'attributes' => $cartItem->attributes
                    ]);
                }

                $order->reserveStock();

                Cart::where('user_id', $user->id)->delete();

                return $order;
            });
            $whatsappMessage = $this->formatWhatsAppMessage($order, $cartItems, $address);
            return redirect()->away($whatsappMessage);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memproses pesanan: ' . $e->getMessage())
                ->withInput();
        }
    }
    private function formatWhatsAppMessage($order, $cartItems, $address)
    {
        $whatsappNumber = '6281318409870';

        // Header pesan
        $message = "Halo Admin, saya ingin memesan produk:\n\n";
        $message .= "*DETAIL PESANAN*\n";
        $message .= "No. Order: {$order->order_number}\n\n";
        $message .= "*PRODUK YANG DIPESAN:*\n";
        foreach ($cartItems as $item) {
            $message .= "- {$item->produk->nama} (x{$item->qty}) = Rp " . number_format($item->price * $item->qty, 0, ',', '.') . "\n";
        }

        $message .= "\n*RINGKASAN PEMBAYARAN:*\n";
        $message .= "Subtotal: Rp " . number_format($order->subtotal, 0, ',', '.') . "\n";
        $message .= "Ongkir: GRATIS\n";
        $message .= "*Total: Rp " . number_format($order->total, 0, ',', '.') . "*\n\n";
        $message .= "*INFO PENGIRIMAN:*\n";
        $message .= "Nama: {$address->recipient_name}\n";
        $message .= "Telepon: {$address->recipient_phone}\n";
        $message .= "Alamat: {$address->full_address}\n\n";
        if ($order->notes) {
            $message .= "*CATATAN:*\n";
            $message .= "{$order->notes}\n\n";
        }
        $message .= "*INSTRUKSI PEMBAYARAN:*\n";
        $message .= "Silakan transfer ke:\n";
        $message .= "Bank: BCA\n";
        $message .= "No. Rek: 8850588091 \n";
        $message .= "Bank: BRI\n";
        $message .= "No. Rek: 018501078107509 \n";
        $message .= "Bank: BSI\n";
        $message .= "No. Rek: 7152989250 \n";
        $message .= "Bank: Mandiri\n";
        $message .= "No. Rek: 1560002592469 \n";
        $message .= "Atas Nama : Lina Herawati \n\n";

        $message .= "Setelah transfer, konfirmasi dengan:\n";
        $message .= "1. Screenshot bukti transfer\n";
        $message .= "2. Kirim ke WhatsApp ini\n";
        $message .= "3. Pesanan akan diproses setelah pembayaran\n\n";

        $message .= "Terima kasih! 🙏";
        $encodedMessage = urlencode($message);
        return "https://wa.me/{$whatsappNumber}?text={$encodedMessage}";
    }
    public function success()
    {
        return view('checkout.success');
    }
    public function instructions()
    {
        return view('checkout.instructions');
    }
}
