<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all(); // Tidak perlu eager load tingkat karena enum
        $tingkats = ['wustha', 'ulya']; // Enum manual
        return view('kelas.index', compact('kelas', 'tingkats'));    
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tingkat' => 'required|in:wustha,ulya',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
        ]);

        return redirect()->back()->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $tingkats = ['wustha', 'ulya'];
        return view('kelas.edit', compact('kelas', 'tingkats'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tingkat' => 'required|in:wustha,ulya',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->back()->with('success', 'Data kelas berhasil dihapus.');
    }
}
