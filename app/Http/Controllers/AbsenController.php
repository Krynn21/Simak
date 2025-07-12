<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\AbsenSessions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AbsenController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sessions = AbsenSessions::orderByDesc('tanggal')->get();

        // Hanya ambil absen milik sendiri jika user adalah pengguna (id_role == 2)
        if ($user->id_role == 2) {
            $absens = Absen::with(['user', 'sesi'])
                ->where('id_user', $user->id)
                ->orderByDesc('created_at')
                ->get();
        } else {
            // Admin bisa melihat semua data absen
            $absens = Absen::with(['user', 'sesi'])
                ->orderByDesc('created_at')
                ->get();
        }

        return view('absen.index', compact('sessions', 'absens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'judul' => 'required|string|max:255'
        ]);

        AbsenSessions::create([
            'tanggal' => $request->tanggal,
            'judul' => $request->judul,
            'is_open' => true,
            'dibuka_pada' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Sesi absen dibuka.');
    }

    public function tutup($id)
    {
        $session = AbsenSessions::findOrFail($id);
        $session->is_open = false;
        $session->ditutup_pada = now();
        $session->save();

        return redirect()->back()->with('success', 'Sesi absen ditutup.');
    }

    public function form()
    {
        $session = AbsenSessions::where('is_open', true)->orderByDesc('tanggal')->first();

        if (!$session) {
            return back()->with('error', 'Tidak ada sesi absen yang dibuka.');
        }

        $sudahAbsen = Absen::where('absen_session_id', $session->id)
            ->where('id_user', Auth::id())
            ->exists();

        return view('guru.absen.form', compact('session', 'sudahAbsen'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alpa',
            'keterangan' => 'nullable'
        ]);

        $session = AbsenSessions::where('is_open', true)->first();

        if (!$session) {
            return back()->with('error', 'Sesi tidak tersedia.');
        }

        // Ganti 1 ke 480 jika waktu absen seharusnya 8 jam (sesuai kode sebelumnya)
        if (now()->diffInMinutes($session->dibuka_pada) > 480) {
            return back()->with('error', 'Waktu absen sudah lewat.');
        }

        $cek = Absen::where('absen_session_id', $session->id)
            ->where('id_user', Auth::id())
            ->first();

        if ($cek) {
            return back()->with('error', 'Kamu sudah absen.');
        }

        Absen::create([
            'id_user' => Auth::id(),
            'absen_session_id' => $session->id,
            'status' => $request->status,
            'keterangan' => $request->keterangan
        ]);

        return redirect('/dashboard')->with('success', 'Absen berhasil.');
    }
}
