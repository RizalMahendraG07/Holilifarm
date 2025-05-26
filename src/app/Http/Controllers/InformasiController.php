<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Informasi;
use Illuminate\Support\Facades\Storage;

class InformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $informasi = Informasi::all();
        return view('admin.informasi', compact('informasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tambahInfo');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Judul'     => 'required',
            'Deskripsi' => 'required',
            'Tanggal'   => 'required|date',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'link'      => 'required|url',
        ]);

        $data = $request->only(['Judul', 'Deskripsi', 'Tanggal','link']);

        if ($request->hasFile('foto')) {
            // Simpan ke storage/app/public/foto_informasi/
            $path = $request->file('foto')->store('foto_informasi', 'public');
            $data['foto'] = $path;
        }

        Informasi::create($data);

        return redirect()->route('informasi.index')
                         ->with('success', 'Informasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $informasi = Informasi::findOrFail($id);
        return view('admin.editinfo', compact('informasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Judul'     => 'required',
            'Deskripsi' => 'required',
            'Tanggal'   => 'required|date',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'link'      => 'required|url',
        ]);

        $informasi = Informasi::findOrFail($id);
        $data = $request->only(['Judul', 'Deskripsi', 'Tanggal', 'link']);


        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($informasi->foto && Storage::disk('public')->exists($informasi->foto)) {
                Storage::disk('public')->delete($informasi->foto);
            }

            // Simpan foto baru
            $path = $request->file('foto')->store('foto_informasi', 'public');
            $data['foto'] = $path;
        }

        $informasi->update($data);

        return redirect()->route('informasi.index')
                         ->with('success', 'Informasi berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $informasi = Informasi::findOrFail($id);

        // Hapus file foto jika ada
        if ($informasi->foto && Storage::disk('public')->exists($informasi->foto)) {
            Storage::disk('public')->delete($informasi->foto);
        }

        $informasi->delete();

        return redirect()->route('informasi.index')
                         ->with('success', 'Informasi berhasil dihapus.');
    }
}
