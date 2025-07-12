<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Ambil data user yang login
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        // 'password' => 'nullable|min:6', // Jika kamu menambahkan fitur ganti password
    ]);

    $user->username = $request->username;

    // if ($request->filled('password')) {
    //     $user->password = Hash::make($request->password);
    // }

    $user->save();

    return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

}
