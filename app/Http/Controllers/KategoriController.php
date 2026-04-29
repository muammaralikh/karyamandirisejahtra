<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class KategoriController extends Controller
{
    private const KATEGORI_IMAGE_DIRECTORY = 'kategori';

    private function setActive($page)
    {
        return [
            'activeKategori' => $page,
            'kategoriActive' => true,
        ];
    }

    private function storeKategoriImage($file): string
    {
        $namaFile = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs(self::KATEGORI_IMAGE_DIRECTORY, $namaFile, 'public');

        $this->syncPublicStorageFile($path);

        return $path;
    }

    private function deleteKategoriImage(?string $gambar): void
    {
        $gambar = trim((string) $gambar);

        if ($gambar === '' || str_starts_with($gambar, 'http://') || str_starts_with($gambar, 'https://')) {
            return;
        }

        $path = str_starts_with($gambar, self::KATEGORI_IMAGE_DIRECTORY . '/')
            ? $gambar
            : self::KATEGORI_IMAGE_DIRECTORY . '/' . ltrim($gambar, '/');

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $this->deletePublicStorageFile($path);
        $this->deletePublicStorageFile(basename($path));
    }

    private function syncPublicStorageFile(string $path): void
    {
        $source = storage_path('app/public/' . $path);
        $destination = public_path('storage/' . $path);

        if (! File::exists($source)) {
            return;
        }

        File::ensureDirectoryExists(dirname($destination));
        File::copy($source, $destination);
    }

    private function deletePublicStorageFile(string $relativePath): void
    {
        $target = public_path('storage/' . ltrim($relativePath, '/'));

        if (File::exists($target)) {
            File::delete($target);
        }
    }

    public function index(Request $request)
    {
        $query = Kategori::query();
        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        
        $kategoris = $query->get();

        return view('admin.pages.kategori', compact('kategoris'), $this->setActive('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'gambar' => 'nullable|image|max:2048',
        ]);
        $gambarPath = null;

        if ($request->hasFile('gambar')) {
            $gambarPath = $this->storeKategoriImage($request->file('gambar'));
        }
        Kategori::create([
            'id' => 'K-' . strtoupper(Str::random(6)),
            'nama' => $request->nama,
            'gambar' => $gambarPath,
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
        $kategori = Kategori::where('id', $id)->firstOrFail();
        $request->validate([
            'nama' => 'required',
            'gambar' => 'nullable|image|max:2048'
        ]);
        $kategori->update([
            'nama' => $request->nama,
        ]);

        if ($request->hasFile('gambar')) {
            $this->deleteKategoriImage($kategori->gambar);

            $kategori->update([
                'gambar' => $this->storeKategoriImage($request->file('gambar')),
            ]);
        }

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate');
    }
    public function destroy($id)
    {
        $kategori = Kategori::where('id', $id)->firstOrFail();

        $this->deleteKategoriImage($kategori->gambar);

        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

}
