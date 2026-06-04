<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\ShippingRate;
use Illuminate\Http\Request;

class ShippingRateController extends Controller
{
    private function setActive(): array
    {
        return [
            'activeOngkirPesanan' => 'ongkir-pesanan',
        ];
    }

    public function index(Request $request)
    {
        $query = ShippingRate::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->where('district_name', 'like', "%{$search}%")
                    ->orWhere('city_name', 'like', "%{$search}%");
            });
        }

        $shippingRates = $query->paginate(10)->withQueryString();

        return view('admin.pages.ongkir-pesanan', compact('shippingRates'), $this->setActive());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'district_name' => 'nullable|string|max:255|required_without:city_name',
            'city_name' => 'nullable|string|max:255|required_without:district_name',
            'tarif_ongkir' => 'required|numeric|min:0',
        ], [
            'district_name.required_without' => 'Isi minimal kecamatan atau kota.',
            'city_name.required_without' => 'Isi minimal kecamatan atau kota.',
            'tarif_ongkir.required' => 'Tarif ongkir wajib diisi.',
            'tarif_ongkir.numeric' => 'Tarif ongkir harus berupa angka.',
            'tarif_ongkir.min' => 'Tarif ongkir tidak boleh kurang dari 0.',
        ]);

        $shippingRate = ShippingRate::create($this->cleanInput($validated));
        ActivityLog::record(
            'tambah_ongkir',
            $shippingRate,
            [],
            $shippingRate->only(['district_name', 'city_name', 'tarif_ongkir']),
            'Tarif ongkir ditambahkan.',
            $this->shippingRateLabel($shippingRate)
        );

        return back()->with('success', 'Tarif ongkir berhasil ditambahkan.');
    }

    public function update(Request $request, ShippingRate $shippingRate)
    {
        $validated = $request->validate([
            'district_name' => 'nullable|string|max:255|required_without:city_name',
            'city_name' => 'nullable|string|max:255|required_without:district_name',
            'tarif_ongkir' => 'required|numeric|min:0',
        ], [
            'district_name.required_without' => 'Isi minimal kecamatan atau kota.',
            'city_name.required_without' => 'Isi minimal kecamatan atau kota.',
            'tarif_ongkir.required' => 'Tarif ongkir wajib diisi.',
            'tarif_ongkir.numeric' => 'Tarif ongkir harus berupa angka.',
            'tarif_ongkir.min' => 'Tarif ongkir tidak boleh kurang dari 0.',
        ]);

        $oldValues = $shippingRate->only(['district_name', 'city_name', 'tarif_ongkir']);
        $shippingRate->update($this->cleanInput($validated));
        $shippingRate->refresh();
        ActivityLog::record(
            'update_ongkir',
            $shippingRate,
            $oldValues,
            $shippingRate->only(['district_name', 'city_name', 'tarif_ongkir']),
            'Tarif ongkir diubah.',
            $this->shippingRateLabel($shippingRate)
        );

        return back()->with('success', 'Tarif ongkir berhasil diupdate.');
    }

    public function destroy(ShippingRate $shippingRate)
    {
        $oldValues = $shippingRate->only(['district_name', 'city_name', 'tarif_ongkir']);
        $label = $this->shippingRateLabel($shippingRate);
        $shippingRate->delete();
        ActivityLog::record(
            'hapus_ongkir',
            $shippingRate,
            $oldValues,
            [],
            'Tarif ongkir dihapus.',
            $label
        );

        return back()->with('success', 'Tarif ongkir berhasil dihapus.');
    }

    private function cleanInput(array $data): array
    {
        return [
            'district_name' => filled($data['district_name'] ?? null) ? trim($data['district_name']) : null,
            'city_name' => filled($data['city_name'] ?? null) ? trim($data['city_name']) : null,
            'tarif_ongkir' => $data['tarif_ongkir'],
        ];
    }

    private function shippingRateLabel(ShippingRate $shippingRate): string
    {
        return collect([$shippingRate->district_name, $shippingRate->city_name])
            ->filter()
            ->implode(', ') ?: 'Tarif ongkir';
    }
}
