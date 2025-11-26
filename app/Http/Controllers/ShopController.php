<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::query();
        
        // Filter by category (support multiple)
        if ($request->has('kategori') && !empty($request->kategori)) {
            $kategoriIds = is_array($request->kategori) ? $request->kategori : [$request->kategori];
            $kategoriIds = array_filter($kategoriIds); // Remove empty values
            if (!empty($kategoriIds)) {
                $query->whereIn('id_kategori', $kategoriIds);
            }
        }
        
        // Filter by price range
        if ($request->has('min_price') && $request->min_price != '' && $request->min_price > 0) {
            $query->where('harga', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != '' && $request->max_price < 500000) {
            $query->where('harga', '<=', $request->max_price);
        }
        
        // Filter by rating (support multiple)
        if ($request->has('rating') && !empty($request->rating)) {
            $ratings = is_array($request->rating) ? $request->rating : [$request->rating];
            $ratings = array_filter($ratings);
            if (!empty($ratings)) {
                $minRating = min($ratings); // Get the minimum rating selected
                $query->whereHas('reviews', function($q) use ($minRating) {
                    $q->where('is_approved', true);
                })->withAvg(['reviews' => function($q) {
                    $q->where('is_approved', true);
                }], 'rating')->having('reviews_avg_rating', '>=', $minRating);
            }
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
        $categories = Kategori::withCount('buku')->get();
        
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
