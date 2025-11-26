<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class AdminKategoriController extends Controller
{
    public function index()
    {
        $categories = Kategori::withCount('buku')->paginate(10);
        return view('admin.kategori.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:t_kategori,nama_kategori',
            'deskripsi' => 'nullable|string',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function show($id)
    {
        $category = Kategori::withCount('buku')->findOrFail($id);
        return view('admin.kategori.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:t_kategori,nama_kategori,' . $id . ',id_kategori',
            'deskripsi' => 'nullable|string',
        ]);

        $category->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy($id)
    {
        $category = Kategori::findOrFail($id);
        
        // Check if category has books
        if ($category->buku()->count() > 0) {
            return redirect()->route('admin.kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki buku!');
        }

        $category->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
