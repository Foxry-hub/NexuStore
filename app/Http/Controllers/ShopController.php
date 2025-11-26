<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::query();
        
        // Filter by category
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('id_kategori', $request->kategori);
        }
        
        // Filter by price range
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('harga', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('harga', '<=', $request->max_price);
        }
        
        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis', 'like', '%' . $request->search . '%')
                  ->orWhere('penerbit', 'like', '%' . $request->search . '%');
            });
        }
        
        // Sorting
        $sortBy = $request->get('sort', 'terbaru');
        switch ($sortBy) {
            case 'harga_terendah':
                $query->orderBy('harga', 'asc');
                break;
            case 'harga_tertinggi':
                $query->orderBy('harga', 'desc');
                break;
            case 'nama_az':
                $query->orderBy('judul', 'asc');
                break;
            case 'nama_za':
                $query->orderBy('judul', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
        
        $books = $query->paginate(12);
        $categories = Kategori::all();
        
        return view('shop.index', compact('books', 'categories'));
    }
    
    public function show($id)
    {
        $book = Buku::findOrFail($id);
        $relatedBooks = Buku::where('id_kategori', $book->id_kategori)
                            ->where('id_buku', '!=', $id)
                            ->limit(4)
                            ->get();
        
        return view('shop.show', compact('book', 'relatedBooks'));
    }
}
