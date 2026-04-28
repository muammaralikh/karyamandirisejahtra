<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
class KategoriController extends Controller
{
    private function setActive($page)
    {
        return [
            'activeKategori' => $page,
            'kategoriActive' => true,
        ];
    }
    public function index(Request $request)
    {
        $query = Kategori::all();
        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        
        $kategoris = Kategori::all();

        return view('admin.pages.kategori', compact( 'kategoris'), $this->setActive('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'gambar' => 'nullable|image|max:2048',
        ]);
        $namaFile = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            Storage::disk('public')->putFileAs('kategori', $file, $namaFile);
        }
        Kategori::create([
            'id' => 'K-' . strtoupper(Str::random(6)),
            'nama' => $request->nama,
            'gambar' => $namaFile,
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan');
    }
    public function update(Request $request, Produk $produk, $id)
    {
        $produk = Kategori::where('id', $id)->firstOrFail();
        $request->validate([
            'nama' => 'required',
            'gambar' => 'nullable|image|max:2048'
        ]);
        $produk->update([
            'nama' => $request->nama,
        ]);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar && Storage::disk('public')->exists('kategori/' . $produk->gambar)) {
                Storage::disk('public')->delete('kategori/' . $produk->gambar);
            }
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            Storage::disk('public')->putFileAs('kategori', $file, $namaFile);
            $produk->update(['gambar' => $namaFile]);
        }

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate');
    }
    public function destroy($id)
    {
        $kategori = Kategori::where('id', $id)->firstOrFail();
        if ($kategori->gambar && Storage::disk('public')->exists('kategori/' . $kategori->gambar)) {
            Storage::disk('public')->delete('kategori/' . $kategori->gambar);
        }
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

}
