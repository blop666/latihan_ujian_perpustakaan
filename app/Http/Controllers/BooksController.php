<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        $title = 'Books';
        return view(
            'dashboard.books.index',
            compact('books', 'title')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add Books';
        return view('dashboard.books.form', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'jenis' => 'required|string|max:30',
            'tahun_terbit' => 'required|date',
            'penulis' => 'required|string|max:30',
            'penerbit' => 'required|string|max:50',
            'stok' => 'required|numeric'
        ]);


        $validated['tahun_terbit'] = Carbon::parse($validated['tahun_terbit'])->year;
        Book::create($validated);

        Alert::success('Berhasil', 'Book Berhasil Ditambahkan');

        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $title = `Edit Books`;

        $book = Book::findOrFail($id);

        return view('dashboard.books.edit', compact('book', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'jenis' => 'required|string|max:30',
            'tahun_terbit' => 'required|date',
            'penulis' => 'required|string|max:30',
            'penerbit' => 'required|string|max:50',
            'stok' => 'required|numeric'
        ]);


        $validated['tahun_terbit'] = Carbon::parse($validated['tahun_terbit'])->year;
        $book = Book::findOrFail($id);
        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Book Berhasil Ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        Alert::warning('Dihapus', 'Book berhasil dihapus');


        return redirect()->route('books.index');
    }
}
