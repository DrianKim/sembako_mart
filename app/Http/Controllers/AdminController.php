<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;            

class AdminController extends Controller
{
    public function dashboard()
    {   
        $data = [
            'title' => 'Dashboard',
        ];

        return view('admin.dashboard', $data);
    }

    public function kategoriIndex()
    {
        $data = [
            'title' => 'Kategori',
        ];

        return view('admin.kategori.index', $data);
    }

    public function kategoriCreate()
    {
        $data = [
            'title' => 'Tambah Kategori',
        ];

        return view('admin.kategori.create', $data);
    }

    public function kategoriStore(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ], [
            'nama_kategori.required' => 'Nama kategori harus diisi!',
            'nama_kategori.string' => 'Nama kategori harus berupa teks!',
            'nama_kategori.max' => 'Nama kategori tidak boleh lebih dari 255 karakter!',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function kategoriEdit($id)
    {
        $kategori = Kategori::findOrFail($id);

        $data = [
            'title' => 'Edit Kategori',
            'kategori' => $kategori,
        ];

        return view('admin.kategori.edit', $data);
    }

    public function kategoriUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ], [
            'nama_kategori.required' => 'Nama kategori harus diisi!',
            'nama_kategori.string' => 'Nama kategori harus berupa teks!',
            'nama_kategori.max' => 'Nama kategori tidak boleh lebih dari 255 karakter!',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil diperbarui!');
    }
}
