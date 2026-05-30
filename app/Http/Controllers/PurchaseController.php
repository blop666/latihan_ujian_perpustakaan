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
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


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
    public function edit($id)
    {
        $title = "Edit Purchase";

        if (!session()->has('can_edit_purchase_' . $id)) {
            return redirect()->route('purchase.show-verify', $id)
                ->with('error', 'Silakan masukkan password otoritas.');
        }

        $purchase = pembelian::findOrFail($id);

        $distributor = distributor::all();

        $books = Book::all();

        return view('dashboard.purchases.edit', compact('title', 'purchase', 'distributor', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Cari data pembelian
        $purchase = pembelian::findOrFail($id);

        // 2. Validasi data (Perhatikan penggunaan ->validate)
        $validate = $request->validate([
            'tgl_nota' => 'required|date',
            'id_distributor' => 'required',
            'total_bayar' => 'required|numeric', 
            'id_buku' => 'required',
            'harga_beli' => 'required|numeric',
            'jumlah_beli' => 'required|integer',
        ]);

        // 3. Update data di tabel pembelian
        $purchase->update([
            'tgl_nota' => $validate['tgl_nota'],
            'id_distributor' => $validate['id_distributor'],
            'total_bayar' => $validate['total_bayar'],
        ]);

        // 4. Update data di tabel detail_pembelian
        // Kita ambil detail pertama karena form edit kamu fokus pada satu item
        $detail = $purchase->detail_pembelians()->first();

        if ($detail) {
            $detail->update([
                'id_buku' => $validate['id_buku'],
                'harga_beli' => $validate['harga_beli'],
                'jumlah_beli' => $validate['jumlah_beli'],
            ]);
        }

        return redirect()->route('purchase.index')->with('Berhasil', 'Data berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    { // Cek apakah session izin sudah ada
        if (!session('can_edit_purchase_' . $id)) {
            return response()->json([
                'success' => false,
                'message' => 'Otoritas diperlukan! Silahkan verifikasi password terlebih dahulu.'
            ], 403);
        }

        $purchase = pembelian::findOrFail($id);
        $purchase->delete();

        // Hapus session setelah berhasil delete agar bersih
        session()->forget('can_edit_purchase_' . $id);

        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }



    public function verify(Request $request, $id)
    {
        // 1. Gunakan Validator manual agar bisa mengontrol respon JSON jika gagal
        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Password wajib diisi.'
            ], 422); // Unprocessable Entity
        }

        
        $kepala = User::query()->where('role', 'kepala perpustakaan')->first();

        if ($kepala && Hash::check($request->password, $kepala->password)) {
            session(['can_edit_purchase_' . $id => true]);

            return response()->json([
                'success' => true,
                'message' => 'Verifikasi berhasil!'
            ]);
        }

        // 4. Respon jika gagal
        return response()->json([
            'success' => false,
            'message' => 'Password salah atau akun kepala perpustakaan tidak ditemukan.'
        ], 401);
    }
}
