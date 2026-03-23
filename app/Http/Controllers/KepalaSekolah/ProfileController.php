<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index(): \Illuminate\View\View
    {
        $user = Auth::user();
        return view('kepala-sekolah.profile.index', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'no_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        $user->update($request->only(['name', 'email', 'no_telepon', 'alamat', 'jenis_kelamin']));

        return redirect()->route('kepala-sekolah.profile.index')
            ->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Update the user's profile photo.
     */
    public function updatePhoto(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Delete old photo if exists
        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        // Upload new photo
        $path = $request->file('foto')->store('profile-photos', 'public');
        $user->update(['foto' => $path]);

        return redirect()->route('kepala-sekolah.profile.index')
            ->with('success', 'Foto profil berhasil diperbarui');
    }

    /**
     * Change the user's password.
     */
    public function changePassword(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('kepala-sekolah.profile.index')
            ->with('success', 'Password berhasil diubah');
    }
}
