<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPelajaranController extends Controller
{
    public function index()
{
    $query = JadwalPelajaran::with(['kelas', 'mapel', 'user.role'])
                ->orderBy('hari')
                ->orderBy('jam_mulai');

    // Jika user bukan admin, tampilkan hanya miliknya
    if (!Auth::user()->isAdmin()) {
        $query->where('user_id', Auth::id());
    }

    $jadwal = $query->get();
    $kelas = Kelas::all();
    $mapel = Mapel::all();
    $users = User::all();

    return view('jadwalpelajaran.index', compact('jadwal', 'kelas', 'mapel', 'users'));
}


    public function create()
    {
        $kelas = Kelas::all();
        $mapel = Mapel::all();
        $users = User::all();
        return view('jadwal.create', compact('kelas', 'mapel','users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapel,id',
            'user_id' => 'required|exists:users,id', // ✅ tambahkan validasi user_id
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);
    
        JadwalPelajaran::create([
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'user_id' => $request->user_id, // ✅ ambil dari input form
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);
    

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
{
    $jadwal = JadwalPelajaran::findOrFail($id); // Tidak perlu where('user_id', ...)
    $kelas = Kelas::all();
    $mapel = Mapel::all();
    $users = User::all(); // Ambil semua user untuk select pengajar

    return view('jadwal.edit', compact('jadwal', 'kelas', 'mapel', 'users'));
}


    public function update(Request $request, $id)
{
    $request->validate([
        'kelas_id' => 'required|exists:kelas,id',
        'mapel_id' => 'required|exists:mapel,id',
        'user_id' => 'required|exists:users,id', // ✅ Tambahkan validasi user_id
        'hari' => 'required|string',
        'jam_mulai' => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
    ]);

    $jadwal = JadwalPelajaran::findOrFail($id); // ✅ Tidak perlu filter user_id

    $jadwal->update([
        'kelas_id' => $request->kelas_id,
        'mapel_id' => $request->mapel_id,
        'user_id' => $request->user_id,
        'hari' => $request->hari,
        'jam_mulai' => $request->jam_mulai,
        'jam_selesai' => $request->jam_selesai,
    ]);

    return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
}


public function destroy($id)
{
    $jadwal = JadwalPelajaran::findOrFail($id); // ✅ Tidak perlu filter user_id
    $jadwal->delete();

    return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
}

}
