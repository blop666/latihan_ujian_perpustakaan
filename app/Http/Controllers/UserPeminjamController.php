<?php

namespace App\Http\Controllers;

use App\Models\peminjam;
use App\Models\peminjaman;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class UserPeminjamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrows = peminjam::all();
        $title = 'userBorrow';

        return view('dashboard.userBorrow.index', compact('title', 'borrows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'userBorrow';
        return view('dashboard.userBorrow.form', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'jk' => 'required|string|max:30',
            'alamat' => 'required|string|max:50',
            'no_telpon' => 'required|string|max:30',
            'email' => 'required|string|max:50',
            'password' => 'required|string|max:30',
            'status' => 'required',
            'foto' => 'required|string|max:200',
            'nip' => 'required|string|max:200',
            'nisn' => 'required|string|max:50',
            'kelas' => 'required|string|max:50',
            'tahun_ajaran' => 'required|string|max:50',
        ]);


        peminjam::create($validated);

        Alert::success('Berhasil', 'User Berhasil Ditambahkan');

        return redirect()->route('userBorrow.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Edit Users';

        $borrow = peminjam::findOrFail($id);
        return view('dashboard.userBorrow.show', compact('title', 'borrow'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Borrow";


        $borrow = peminjam::findOrFail($id);
        return view('dashboard.userBorrow.edit', compact('title', 'borrow'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'jk' => 'required|string|max:30',
            'alamat' => 'required|string|max:50',
            'no_telpon' => 'required|string|max:30',
            'email' => 'required|string|max:50',
            'status' => 'required',
            'foto' => 'required|string|max:200',
            'nip' => 'required|string|max:200',
            'nisn' => 'required|string|max:50',
            'kelas' => 'required|string|max:50',
            'tahun_ajaran' => 'required|string|max:50',
        ]);

        $book = peminjam::findOrFail($id);

        $book->update($validated);

        return redirect()->route('borrow.index')->with('success', 'Book Berhasil Ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $title = "Borrow";
        $borrow = peminjam::findOrFail($id);
        $borrow->delete();

        Alert::warning('Dihapus', 'Data Berhasil Diapus');

        return redirect()->route('borrow.index');

    }
}
