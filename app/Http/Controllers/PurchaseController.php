<?php

namespace App\Http\Controllers;

use App\Models\distributor;
use App\Models\pembelian;
use App\Models\detail_pembelian;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\peminjam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Purchase';
        $purchase = pembelian::all();

        return view('dashboard.purchases.index', compact('title', 'purchase'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Purchase';
        $distributor = distributor::all();
        $books = Book::all();


        return view('dashboard.purchases.form', compact('title', 'distributor', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { {
            // Validasi tetap perlu untuk memastikan input user benar
            $request->validate([
                'tgl_nota' => 'required|date',
                'id_distributor' => 'required',
                'id_buku' => 'required',
                'jumlah_beli' => 'required|numeric',
                'harga_beli' => 'required|numeric',
            ]);

            DB::transaction(function () use ($request) {
                // 1. Simpan Header Pembelian
                // Kita set total_bayar ke 0 karena Trigger simpan_purchase_detail 
                // akan otomatis menjumlahkannya nanti.
                $pembelian = pembelian::create([
                    'tgl_nota' => $request->tgl_nota,
                    'id_distributor' => $request->id_distributor,
                    'total_bayar' => 0,
                ]);

                // 2. Simpan Detail Pembelian
                // Begitu baris ini dieksekusi, TRIGGER di database akan langsung:
                // - Menambah stok di tabel 'books'
                // - Mengupdate 'total_bayar' di tabel 'pembelians'
                detail_pembelian::create([
                    'id_pembelian' => $pembelian->id,
                    'id_buku' => $request->id_buku,
                    'jumlah_beli' => $request->jumlah_beli,
                    'harga_beli' => $request->harga_beli,
                    'subtotal' => $request->harga_beli * $request->jumlah_beli,
                ]);
            });

            return redirect()->route('purchase.index')->with('success', 'Data berhasil disimpan (Stok & Total diupdate oleh Database)');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Purchase Detail';
        // Menggunakan Eager Loading agar query efisien
        $purchase = pembelian::with(['distributor', 'detail_pembelians.book'])->findOrFail($id);

        return view('dashboard.purchases.show', compact('title', 'purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Purchase";
        $distributor = distributor::findOrFail($id);
        $purchase = pembelian::findOrFail($id);

        return view('dashboard.purchases.edit', compact('title', 'purchase', 'distributor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $purchase = pembelian::findOrFail($id);

        $validate = $request([
            'tgl_nota' => 'required|date',
            'id_distributor' => 'required',
            'total_bayar' => 'required|string|max:20',
        ]);

        $purchase->update($validate);

        return redirect()->route('purchase.index')->with('Berhasil', 'Data berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    { {
            // Cukup hapus detailnya saja
            $detail = detail_pembelian::where('id_pembelian', $id)->delete();
            // Lalu hapus headernya
            pembelian::destroy($id);

            return redirect()->back()->with('success', 'Data dihapus & stok dikembalikan otomatis oleh Trigger');
        }
    }
}
