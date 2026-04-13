<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Str;
class ProdukController extends Controller
{
    private function setActive($page)
    {
        return [
            'activeProduk' => $page,
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
    public function showall()
    {
        $data = [
            'title' => 'Semua Produk',
            'categories' => Kategori::latest()->get(),
            'Allproducts' => Produk::with('kategori')
                ->latest()
                ->get(),

        ];
        return view('pages.produk', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',
            'nama' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'required',
            'gambar' => 'nullable|max:2048',
        ]);
        $namaFile = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage'), $namaFile);
        }

        Produk::create([
            'id' => 'P-' . strtoupper(Str::random(6)),
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
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
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|max:2048',
        ]);
        $produk->update([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
        ]);
        if ($request->hasFile('gambar')) {
            if ($produk->gambar && file_exists(public_path('storage/' . $produk->gambar))) {
                unlink(public_path('storage/' . $produk->gambar));
            }
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage'), $namaFile);
            $produk->update(['gambar' => $namaFile]);
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate');
    }
    public function destroy($id)
    {
        $produk = Produk::where('id', $id)->firstOrFail();
        if ($produk->gambar && file_exists(public_path('storage/' . $produk->gambar))) {
            unlink(public_path('storage/' . $produk->gambar));
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
