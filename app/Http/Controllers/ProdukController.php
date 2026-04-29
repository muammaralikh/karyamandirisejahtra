<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProdukController extends Controller
{
    private const PRODUK_IMAGE_DIRECTORY = 'produk';

    private function setActive($page)
    {
        return [
            'activeProduk' => $page === 'produk' ? 'produk' : '',
            'activeStokProduk' => $page === 'stok-produk' ? 'stok-produk' : '',
            'produkActive' => true,
        ];
    }

    private function storeProductImage($file): string
    {
        $namaFile = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs(self::PRODUK_IMAGE_DIRECTORY, $namaFile, 'public');

        $this->syncPublicStorageFile($path);

        return $path;
    }

    private function deleteProductImage(?string $gambar): void
    {
        $gambar = trim((string) $gambar);

        if ($gambar === '' || str_starts_with($gambar, 'http://') || str_starts_with($gambar, 'https://')) {
            return;
        }

        $path = str_starts_with($gambar, self::PRODUK_IMAGE_DIRECTORY . '/')
            ? $gambar
            : self::PRODUK_IMAGE_DIRECTORY . '/' . ltrim($gambar, '/');

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
        $query = Produk::with('kategori');
        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        if ($request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }

        $produk = $query->paginate(10)->withQueryString();
        $kategoris = Kategori::all();

        return view('admin.pages.produk', compact('produk', 'kategoris'), $this->setActive('produk'));
    }

    public function stock()
    {
        $stockProduk = Produk::with('kategori')->orderBy('nama')->get();

        return view('admin.pages.stok-produk', compact('stockProduk'), $this->setActive('stok-produk'));
    }
    public function showall(Request $request)
    {
        $productsQuery = Produk::with('kategori')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $productsQuery->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%')
                    ->orWhereHas('kategori', function ($kategoriQuery) use ($search) {
                        $kategoriQuery->where('nama', 'like', '%' . $search . '%');
                    });
            });
        }

        $data = [
            'title' => 'Semua Produk',
            'categories' => Kategori::latest()->get(),
            'Allproducts' => $productsQuery->get(),
            'searchKeyword' => $request->search,
        ];
        return view('pages.produk', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $gambarPath = null;

        if ($request->hasFile('gambar')) {
            $gambarPath = $this->storeProductImage($request->file('gambar'));
        }

        Produk::create([
            'id' => 'P-' . strtoupper(Str::random(6)),
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $gambarPath,
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
        $produk = Produk::where('id', $id)->firstOrFail();
        $request->validate([
            'kategori_id' => 'required',
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
        ]);
        $produk->update([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
        ]);
        if ($request->hasFile('gambar')) {
            $this->deleteProductImage($produk->gambar);

            $produk->update([
                'gambar' => $this->storeProductImage($request->file('gambar')),
            ]);
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate');
    }
    public function destroy($id)
    {
        $produk = Produk::where('id', $id)->firstOrFail();

        $this->deleteProductImage($produk->gambar);

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
    public function byCategory($id)
    {
        $category = Kategori::findOrFail($id);

        $products = Produk::where('kategori_id', $id)->get();
        $categories = Kategori::latest()->get();

        return view('pages.kategori', compact('category', 'categories', 'products'));
    }


}
