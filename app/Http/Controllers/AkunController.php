<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\GeneratesUniqueUsername;
use App\Models\Address;
use App\Models\ActivityLog;
use App\Models\City;
use App\Models\District;
use App\Models\Kategori;
use App\Models\Order;
use App\Models\Produk;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AkunController extends Controller
{
    use GeneratesUniqueUsername;

    public function myAccount()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }
        $user->load([
            'addresses' => function ($query) {
                $query->with(['province', 'city', 'district']);
            }
        ]);
        $orders = $user->orders()
            ->with(['items.product'])
            ->latest()
            ->paginate(10);
        $stockProducts = Produk::with('kategori')->orderBy('nama')->get();
        $provinces = Province::orderBy('name')->get();
        $categories = Kategori::latest()->get();

        return view('akun.index', compact('user', 'categories', 'provinces', 'orders', 'stockProducts'));
    }

    public function updateMyAccount(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        ], [
            'name.required' => 'Nama lengkap harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
        ]);

        try {
            // Update data user
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->username = $validated['username'];

            $user->save();

            return redirect()->route('user.account.my-account')->with([
                'success' => 'Data akun berhasil diperbarui!',
                'tab' => 'profile'
            ]);

        } catch (\Exception $e) {
            return back()->withInput()->withErrors([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Validasi
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ], [
            'current_password.required' => 'Password saat ini harus diisi',
            'password.required' => 'Password baru harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok'
        ]);
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini salah.'
            ])->withInput()->with('tab', 'password');
        }

        // Update password
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('user.account.my-account')->with([
            'success' => 'Password berhasil diubah!',
            'tab' => 'password'
        ]);
    }
    public function updateAddress(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'address_label' => 'nullable|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => ['required', 'string', 'regex:/^(08\d{6,11}|62\d{6,11})$/'],
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'postal_code' => ['required', 'string', 'max:10', 'regex:/^\d+$/'],
            'street' => ['required', 'string', 'regex:/^[A-Za-z]/'],
            'notes' => 'nullable|string|max:500',
            'is_primary' => 'nullable|boolean',
            'address_id' => 'nullable|exists:addresses,id'
        ], [
            'recipient_phone.required' => 'Nomor HP penerima harus diisi',
            'recipient_phone.regex' => 'nomor harus di awali 08/62',
            'postal_code.required' => 'Kode pos harus diisi',
            'postal_code.regex' => 'Kode pos hanya boleh berisi angka',
            'street.required' => 'Alamat lengkap harus diisi',
            'street.regex' => 'Alamat lengkap harus diawali dengan huruf',
        ]);
        $province = Province::find($validated['province_id']);
        $city = City::find($validated['city_id']);
        $district = District::find($validated['district_id']);

        $addressData = [
            'label' => $validated['address_label'] ?? 'Alamat Pengiriman',
            'recipient_name' => $validated['recipient_name'],
            'recipient_phone' => $validated['recipient_phone'],
            'province_id' => $validated['province_id'],
            'city_id' => $validated['city_id'],
            'district_id' => $validated['district_id'],
            'province_name' => $province->name,
            'city_name' => $city->name . ($city->type ? ' (' . $city->type . ')' : ''),
            'district_name' => $district->name,
            'postal_code' => $validated['postal_code'],
            'street' => $validated['street'],
            'notes' => $validated['notes'] ?? null,
            'is_primary' => $validated['is_primary'] ?? false
        ];

        if ($request->address_id) {
            $address = Address::where('user_id', $user->id)
                ->where('id', $request->address_id)
                ->firstOrFail();

            if ($request->is_primary && !$address->is_primary) {
                Address::where('user_id', $user->id)->update(['is_primary' => false]);
            }

            $address->update($addressData);
            $message = 'Alamat berhasil diperbarui!';
        } else {
            if ($request->is_primary || $user->addresses()->count() === 0) {
                Address::where('user_id', $user->id)->update(['is_primary' => false]);
                $addressData['is_primary'] = true;
            }

            $user->addresses()->create($addressData);
            $message = 'Alamat berhasil ditambahkan!';
        }

        return redirect()->route('user.account.my-account')->with([
            'success' => $message,
            'tab' => 'address'
        ]);
    }

    // Hapus alamat
    public function deleteAddress($id)
    {
        $user = Auth::user();
        $address = $user->addresses()->findOrFail($id);

        if ($address->is_primary && $user->addresses()->count() > 1) {
            return redirect()->route('user.account.my-account')->with([
                'error' => 'Tidak dapat menghapus alamat utama. Silakan tentukan alamat utama baru terlebih dahulu.',
                'tab' => 'address'
            ]);
        }

        $address->delete();

        return redirect()->route('user.account.my-account')->with([
            'success' => 'Alamat berhasil dihapus!',
            'tab' => 'address'
        ]);
    }

    public function uploadPaymentProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ], [
            'payment_proof.required' => 'Bukti transfer wajib diupload.',
            'payment_proof.mimes' => 'Bukti transfer harus berupa file JPG, JPEG, PNG, atau PDF.',
            'payment_proof.max' => 'Ukuran bukti transfer maksimal 4MB.',
        ]);

        $user = Auth::user();
        $order = $user->orders()->findOrFail($id);

        if ($order->isExpiredPendingPayment()) {
            $oldValues = $order->only(['status', 'cancelled_at', 'cancellation_reason']);
            $order->cancel('Batal - tidak ada konfirmasi pembayaran dalam 1x24 jam.');

            ActivityLog::record(
                'auto_batal_pesanan',
                $order,
                $oldValues,
                $order->only(['status', 'cancelled_at', 'cancellation_reason']),
                "Pesanan {$order->order_number} otomatis batal karena melewati 1x24 jam.",
                $order->order_number
            );

            return redirect()->route('user.account.my-account')->with([
                'error' => 'Pesanan sudah melewati batas 1x24 jam dan otomatis dibatalkan.',
                'tab' => 'orders'
            ]);
        }

        if (! $order->isPendingPayment()) {
            return redirect()->route('user.account.my-account')->with([
                'error' => 'Hanya pesanan Pending yang bisa mengunggah bukti transfer.',
                'tab' => 'orders'
            ]);
        }

        $paymentProofPath = $this->storePaymentProof($request->file('payment_proof'));
        $oldValues = $order->only(['status', 'paid_at', 'payment_proof']);
        $order->markAsPaid($paymentProofPath);

        ActivityLog::record(
            'upload_bukti_transfer',
            $order,
            $oldValues,
            $order->only(['status', 'paid_at', 'payment_proof']),
            "Bukti transfer untuk pesanan {$order->order_number} diupload oleh pelanggan.",
            $order->order_number
        );

        return redirect()->route('user.account.my-account')->with([
            'success' => 'Bukti transfer berhasil diupload. Pesanan otomatis ditandai lunas.',
            'tab' => 'orders'
        ]);
    }

    private function storePaymentProof($file): string
    {
        $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('payment-proofs', $filename, 'public');

        $source = storage_path('app/public/' . $path);
        $destination = public_path('storage/' . $path);

        if (File::exists($source)) {
            File::ensureDirectoryExists(dirname($destination));
            File::copy($source, $destination);
        }

        return $path;
    }

    // Set alamat sebagai utama
    public function setPrimaryAddress($id)
    {
        $user = Auth::user();
        $address = $user->addresses()->findOrFail($id);

        // Set semua alamat sebagai non-primary
        $user->addresses()->update(['is_primary' => false]);

        // Set alamat ini sebagai primary
        $address->update(['is_primary' => true]);

        return redirect()->route('user.account.my-account')->with([
            'success' => 'Alamat utama berhasil diubah!',
            'tab' => 'address'
        ]);
    }

    // Hapus order (hanya bisa jika status pending atau lunas)
    public function deleteOrder($id)
    {
        $user = Auth::user();
        $order = $user->orders()->findOrFail($id);

        if (!$order->canBeDeleted()) {
            return redirect()->route('user.account.my-account')->with([
                'error' => 'Pesanan hanya bisa dihapus saat status Pending atau Lunas. Hubungi admin jika sudah dikonfirmasi.',
                'tab' => 'orders'
            ]);
        }

        try {
            $oldValues = [
                'order_number' => $order->order_number,
                'status' => $order->status,
                'total' => $order->total,
            ];

            // Simpan informasi order sebelum dihapus untuk log
            $orderNumber = $order->order_number;

            // Hapus order items dulu
            $order->items()->delete();

            // Hapus order
            $order->delete();

            ActivityLog::record(
                'hapus_order_user',
                null,
                $oldValues,
                [],
                "Pesanan {$orderNumber} dihapus oleh pelanggan {$user->name}.",
                $orderNumber
            );

            return redirect()->route('user.account.my-account')->with([
                'success' => 'Pesanan berhasil dihapus!',
                'tab' => 'orders'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('user.account.my-account')->with([
                'error' => 'Terjadi kesalahan saat menghapus pesanan: ' . $e->getMessage(),
                'tab' => 'orders'
            ]);
        }
    }

}

