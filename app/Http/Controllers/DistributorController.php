<?php

namespace App\Http\Controllers;

use App\Models\distributor;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Distributor';
        $dist = distributor::all();

        return view('dashboard.distributor.index', compact('title', 'dist'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Distributor';

        return view('dashboard.distributor.form', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama_distributor' => 'required|string|max:50',
            'alamat' => 'required|string|max:50',
            'no_telpon' => 'required|string|max:12'
        ]);

        distributor::create($validate);

        Alert::success('Berhasil', 'Data Berhasil Ditambahkan');

        return redirect()->route('distributor.index')->with('Berhasil', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Distributor';
        $dist = distributor::findOrFail($id);

        return view('dashboard.distributor.edit', compact('title', 'dist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $dist = distributor::findOrFail($id);


        $validate = $request->validate([
            'nama_distributor' => 'required|string|max:50',
            'alamat' => 'required|string|max:50',
            'no_telpon' => 'required|string|max:12'
        ]);

        $dist->update($validate);

        return redirect()->route('distributor.index')->with('Berhasil', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $dist = distributor::findOrFail($id);

        $dist->delete();
        return redirect()->route('distributor.index')->with('Dihapus', 'Data berhasil Dihapus');
    }
}
