<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBukuController extends Controller
{
    public function index()
    {
        $books = Buku::with('kategori')->paginate(10);
        return view('admin.buku.index', compact('books'));
    }

    public function create()
    {
        $categories = Kategori::all();
        return view('admin.buku.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:200',
            'penulis' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn' => 'nullable|string|max:20|unique:t_buku,isbn',
            'jumlah_halaman' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'id_kategori' => 'required|exists:t_kategori,id_kategori',
            'gambar_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('gambar_cover');

        if ($request->hasFile('gambar_cover')) {
            $data['gambar_cover'] = $request->file('gambar_cover')->store('books', 'public');
        }

        Buku::create($data);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show($id)
    {
        $book = Buku::with('kategori')->findOrFail($id);
        return view('admin.buku.show', compact('book'));
    }

    public function edit($id)
    {
        $book = Buku::findOrFail($id);
        $categories = Kategori::all();
        return view('admin.buku.edit', compact('book', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $book = Buku::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:200',
            'penulis' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn' => 'nullable|string|max:20|unique:t_buku,isbn,' . $id . ',id_buku',
            'jumlah_halaman' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'id_kategori' => 'required|exists:t_kategori,id_kategori',
            'gambar_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('gambar_cover');

        if ($request->hasFile('gambar_cover')) {
            // Delete old image
            if ($book->gambar_cover) {
                Storage::disk('public')->delete($book->gambar_cover);
            }
            $data['gambar_cover'] = $request->file('gambar_cover')->store('books', 'public');
        }

        $book->update($data);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy($id)
    {
        $book = Buku::findOrFail($id);

        // Delete image
        if ($book->gambar_cover) {
            Storage::disk('public')->delete($book->gambar_cover);
        }

        $book->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}
