<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class ProdukController extends Controller
{
    private function setActive($page)
    {
        return [
            'activeProduk' => $page === 'produk' ? 'produk' : '',
            'activeStokProduk' => $page === 'stok-produk' ? 'stok-produk' : '',
            'produkActive' => true,
        ];
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
        $namaFile = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            Storage::disk('public')->putFileAs('produk', $file, $namaFile);
        }

        Produk::create([
            'id' => 'P-' . strtoupper(Str::random(6)),
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $namaFile,
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan');
    }
    public function update(Request $request, Produk $produk, $id)
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
            // Delete old file if exists
            if ($produk->gambar && Storage::disk('public')->exists('produk/' . $produk->gambar)) {
                Storage::disk('public')->delete('produk/' . $produk->gambar);
            }
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            Storage::disk('public')->putFileAs('produk', $file, $namaFile);
            $produk->update(['gambar' => $namaFile]);
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate');
    }
    public function destroy($id)
    {
        $produk = Produk::where('id', $id)->firstOrFail();
        if ($produk->gambar && Storage::disk('public')->exists('produk/' . $produk->gambar)) {
            Storage::disk('public')->delete('produk/' . $produk->gambar);
        }
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
