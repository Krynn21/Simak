<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Mapel;

class MapelController extends Controller

{
    public function index()
    {
        $mapel = Mapel::all();
        return view('mapel.index', compact('mapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
        ]);

        Mapel::create([
            'nama_mapel' => $request->nama_mapel,
        ]);

        return redirect()->back()->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mapel = Mapel::findOrFail($id);
        return view('mapel.edit', compact('mapel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
        ]);

        $mapel = Mapel::findOrFail($id);
        $mapel->update([
            'nama_mapel' => $request->nama_mapel,
        ]);

        return redirect()->route('mapel.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->delete();

        return redirect()->back()->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}