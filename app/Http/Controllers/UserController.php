<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Tampilkan semua user petugas
    public function index()
    {
        $users = User::all();
        $title = "Users";
        return view('dashboard.users.index', compact('users', 'title'));
    }

    // Form Tambah User
    public function create()
    {
        $title = "Users";
        return view('dashboard.users.form', compact('title'));
    }

    // Simpan User Baru
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role'     => 'required',
            'photo'    => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password); // Enkripsi password

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('user_photos', 'public');
        }

        User::create($data);
        return redirect()->route('users.index')->with('success', 'Petugas berhasil ditambahkan.');
    }

    // Form Edit User
    public function edit(User $user)
    {
        $title = "Edit Petugas: " . $user->username;
        return view('dashboard.users.edit', compact('user', 'title'));
    }

    // Update Data User
    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required',
            'photo'    => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = $request->only(['username', 'email', 'role']);

        // Update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Update foto jika ada file baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('user_photos', 'public');
        }

        $user->update($data);
        return redirect()->route('users.index')->with('success', 'Data petugas diperbarui.');
    }

    // Hapus User
    public function destroy(User $user)
    {
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Petugas berhasil dihapus.');
    }
}