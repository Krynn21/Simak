<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;
use App\Models\User;
use App\Models\AbsenSessions;
use App\Models\Absen;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Guru;
use App\Models\Role;

class AuthController extends Controller

{
    public function index()
    {
        $user = Auth::user()->load('role'); // force eager load relasi       // << ini kamu ambil, tapi tidak dikirim ke view
        $roles = Role::all();
        $jumlahUsers = User::count();
        $jumlahKelas = Kelas::count();
        $jumlahMapel = Mapel::count();
        $absenAktif = AbsenSessions::where('is_open', 1)->latest('tanggal')->first();
        $sudahAbsen = false;

        if ($absenAktif) {
            $sudahAbsen = Absen::where('absen_session_id', $absenAktif->id)
                ->where('id_user', $user->id)
                ->exists();
        }

        // Ambil semua sesi absen yang terbuka
        // $absenSessions = AbsenSession::where('is_open', true)->get();

        // Kirim ke view
        return view('index', compact('user', 'roles','jumlahUsers','jumlahKelas','jumlahMapel','absenAktif','sudahAbsen'));
    }
    public function showLogin()
    {
        return view('login');
    }

    // public function processLogin(Request $request)
    // {
    //     $credentials = $request->only('username', 'password');

    //     if (Auth::attempt($credentials)) {
    //         return redirect()->intended('/dashboard');
    //     }

    //     return back()->with('error', 'Username atau password salah!');
    // }
    public function processLogin(Request $request)
    {
        $credentials = $request->only('username', 'password');
        // $absenSessions = AbsenSession::where('is_open', true)->get();
        // Cek apakah username ada di database
        $user = User::where('username', $credentials['username'])->first();
    
        if ($user) {
            // Username ditemukan, sekarang cek password
            if (Hash::check($credentials['password'], $user->password)) {
                Auth::login($user);
                return redirect()->intended('/dashboard');
            } else {
                return back()->with('error', 'Password salah!');
            }
        } else {
            return back()->with('error', 'Username tidak ditemukan!');
        }
        $bsenSessions = absen_sessions::where('is_open', true)->get();

        // Kirim ke view
        return view('/dashboard', compact('absenSessions'));  
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
    public function bukaAbsen(Request $request) {
        $absenSessions = absen_sessions::open()->get();
        absen_sessions::create([
            'judul' => $request->judul,
            'tanggal' => $request->tanggal,
            'is_open' => true,
        ]);
    }
    public function rekap($id)
    {
        // Ambil semua data absen untuk sesi tertentu, termasuk data user-nya
        $rekap = Absen::with('user')->where('absen_session_id', $id)->get();

        return view('admin.absen.rekap', compact('rekap'));
    }
    
}