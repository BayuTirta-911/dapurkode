<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Impor model User
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Impor Hash untuk mengenkripsi password

class UserController extends Controller
{
    public function signupForm()
{
    return view('auth.signup');
}
public function dashboard()
{
    return view('dashboard');
}
public function signup(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:vendor,installer,affiliator,user',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    return redirect('/login')->with('success', 'Account created successfully!');
}

public function profile()
    {
        // Mengambil semua pengguna yang terdaftar
        $users = User::all();

        return view('profile/view', compact('users'));
    }

    public function editprofile()
    {
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login
        return view('profile.edit', compact('user'));
    }

    // Memproses pembaruan profil
    public function updateprofile(Request $request)
    {
        // \Log::info('Update profile function called');
        $user = Auth::user();

        if ($request->hasFile('profile_photo') && $request->file('profile_photo')->getSize() > 2 * 1024 * 1024) {
            return redirect()->back()->with('error', 'The uploaded file is too large. Maximum size is 2 MB.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email,{$user->id}",
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Upload foto profil baru jika ada
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Simpan foto baru
            $user->profile_photo = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
    

}
