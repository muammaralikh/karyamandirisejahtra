<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PesananController;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('media:sync-images', function () {
    $syncTable = function (string $table, string $directory) {
        $rows = DB::table($table)->select('id', 'gambar')->get();
        $synced = 0;

        foreach ($rows as $row) {
            $gambar = trim((string) $row->gambar);

            if ($gambar === '' || str_starts_with($gambar, 'http://') || str_starts_with($gambar, 'https://')) {
                continue;
            }

            $normalized = str_starts_with($gambar, $directory . '/')
                ? $gambar
                : $directory . '/' . ltrim(str_replace('storage/', '', $gambar), '/');

            if ($normalized !== $gambar) {
                DB::table($table)->where('id', $row->id)->update(['gambar' => $normalized]);
            }

            $basename = basename($normalized);
            $storageTarget = storage_path('app/public/' . $normalized);
            $publicTarget = public_path('storage/' . $normalized);
            $legacyPublicFile = public_path('storage/' . $basename);
            $legacyStorageFile = storage_path('app/public/' . $basename);

            File::ensureDirectoryExists(dirname($storageTarget));
            File::ensureDirectoryExists(dirname($publicTarget));

            if (! File::exists($storageTarget)) {
                if (File::exists($legacyStorageFile)) {
                    File::copy($legacyStorageFile, $storageTarget);
                } elseif (File::exists($legacyPublicFile)) {
                    File::copy($legacyPublicFile, $storageTarget);
                }
            }

            if (File::exists($storageTarget) && ! File::exists($publicTarget)) {
                File::copy($storageTarget, $publicTarget);
            }

            if (Storage::disk('public')->exists($normalized)) {
                $synced++;
            }
        }

        return $synced;
    };

    $produkSynced = $syncTable('produk', 'produk');
    $kategoriSynced = $syncTable('kategori', 'kategori');

    $this->info("Sinkronisasi selesai. Produk: {$produkSynced}, Kategori: {$kategoriSynced}");
})->purpose('Sinkronkan path database dan file gambar produk/kategori');

Artisan::command('orders:cancel-expired-pending', function () {
    $cancelled = PesananController::cancelExpiredPendingOrders();

    $this->info("Pesanan pending yang otomatis batal: {$cancelled}");
})->purpose('Batalkan pesanan pending yang melewati batas 1x24 jam');
