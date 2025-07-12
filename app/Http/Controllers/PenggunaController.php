<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\User;
use App\Models\Role;
use App\Models\Absensessions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PenggunaController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $user = User::with('role')->get();

        return view('pengguna.index', compact('roles', 'user'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('pengguna.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'id_role'  => 'required|exists:roles,id',
        ]);

        User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'id_role'  => $request->id_role,
        ]);

        return redirect()->route('pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $pengguna)
    {
        $roles = Role::all();
        return view('pengguna.edit', compact('pengguna', 'roles'));
    }

    public function update(Request $request, User $pengguna)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'nullable|string',
            'id_role'  => 'required|exists:roles,id',
        ]);

        $pengguna->username = $request->username;

        if ($request->filled('password')) {
            $pengguna->password = bcrypt($request->password);
        }

        $pengguna->id_role = $request->id_role;
        $pengguna->save();

        return redirect()->route('pengguna.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    public function isiAbsen(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $session = Absensessions::findOrFail($request->absen_session_id);

        if (Absen::where('id_user', $user->id)->where('absen_session_id', $session->id)->exists()) {
            return back()->with('error', 'Anda sudah mengisi absen.');
        }

        Absen::create([
            'id_user' => $user->id,
            'absen_session_id' => $session->id,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Absen berhasil disimpan.');
    }
}
