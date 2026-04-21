<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\GeneratesUniqueUsername;
use App\Models\Address;
use App\Models\City;
use App\Models\District;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'gender' => 'nullable|in:male,female',
        ], [
            'name.required' => 'Nama lengkap harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'username.unique' => 'Username sudah digunakan',
        ]);

        try {
            // Update data user
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->username = $validated['username'] ?? $this->generateUniqueUsernameFromEmail($validated['email'], $user->id);
            $user->gender = $validated['gender'] ?? null;

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
            'address_label' => 'required|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'postal_code' => 'required|string|max:10',
            'street' => 'required|string',
            'notes' => 'nullable|string|max:500',
            'is_primary' => 'nullable|boolean',
            'address_id' => 'nullable|exists:addresses,id'
        ]);
        $province = Province::find($validated['province_id']);
        $city = City::find($validated['city_id']);
        $district = District::find($validated['district_id']);

        $addressData = [
            'label' => $validated['address_label'],
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
            return redirect()->route('account.my-account')->with([
                'error' => 'Tidak dapat menghapus alamat utama. Silakan tentukan alamat utama baru terlebih dahulu.',
                'tab' => 'address'
            ]);
        }

        $address->delete();

        return redirect()->route('account.my-account')->with([
            'success' => 'Alamat berhasil dihapus!',
            'tab' => 'address'
        ]);
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

}
