<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    //
    public function index(){

         return view('admin.profile.edit', [
            'user' => Auth::user()
        ]);

    }

    public function edit(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'divisi' => 'required|in:inti,acara,pubdok,perlengkapan,humas',
        'password' => 'nullable|string|min:6',
        'profile_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->divisi = $request->divisi;

    // Ganti password jika diisi
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    // Upload gambar profil baru
    if ($request->hasFile('profile_img')) {
        // Hapus gambar lama jika ada
        if ($user->profile_img && Storage::disk('public')->exists($user->profile_img)) {
            Storage::disk('public')->delete($user->profile_img);
        }

        // Simpan gambar baru
        $image_path = $request->file('profile_img')->store('profile_images', 'public');
        $user->profile_img = $image_path;
    }

    $user->save();

    return redirect()->back()->with('success', 'Profile berhasil diubah');
}
}
