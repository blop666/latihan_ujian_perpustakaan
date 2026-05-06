<?php

namespace App\Http\Controllers;

use App\Models\peminjam;
use App\Models\peminjaman;
use App\Models\Book;
use App\Models\detail_pembelian;
use App\Models\detail_peminjaman;
use App\Models\pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Borrow';
        $book = Book::all();

        $borrow = peminjaman::all();

        return view('dashboard.borrow.index', compact('borrow', 'title', 'book'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Borrow';
        $borrow = peminjaman::all();
        $books = Book::all();
        $peminjam = peminjam::all();

        return view('dashboard.borrow.form', compact('borrow', 'title', 'books', 'peminjam'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tgl_pinjam'    => 'required',
            'id_peminjam'   => 'required',
            'id_buku'       => 'required',
            'jumlah_pinjam' => 'required|numeric|min:1',
            'tgl_kembali'   => 'required|date', // Deadline
            'denda_perhari' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Simpan ke tabel peminjamen (Header)
            $peminjaman = peminjaman::create([
                'tgl_pinjam'   => $request->tgl_pinjam,
                'id_peminjam'  => $request->id_peminjam,
                'total_pinjam' => $request->jumlah_pinjam,
                'total_denda'  => 0, // Awal pinjam denda masih 0
            ]);

            // 2. Simpan ke tabel detail_peminjamen
            // TRIGGER stok_berkurang_pinjam akan otomatis memotong stok buku
            detail_peminjaman::create([
                'id_peminjaman'   => $peminjaman->id,
                'id_buku'         => $request->id_buku,
                'tgl_kembali'     => $request->tgl_kembali,
                'denda_perhari'   => $request->denda_perhari,
                'jumlah_pinjam'   => $request->jumlah_pinjam,
                'status_pinjam'   => 'P', // P = Pinjam, K = Kembali
                'keterangan'      => $request->keterangan,
                'bayar_denda'     => 0,
                'jumlah_terlambat' => 0,
            ]);
        });

        return redirect()->route('borrow.index')->with('success', 'Peminjaman berhasil dicatat!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $title = 'Detail Peminjaman';
        // Load semua relasi agar data muncul lengkap
        $data = peminjaman::with(['peminjam', 'detail_peminjaman.book'])->findOrFail($id);

        return view('dashboard.borrow.show', compact('data', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Borrow';
        $peminjam = peminjam::findOrFail($id); // Mencari data berdasarkan ID
        return view('dashboard.borrow.edit', compact('peminjam', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}
}
