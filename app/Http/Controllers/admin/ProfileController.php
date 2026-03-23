<?php
// app/Http/Controllers/Admin/ProfileController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Activity;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Ambil activity logs
        $activities = $user->activities()
            ->latest()
            ->limit(20)
            ->get();
        
        return view('admin.profile.index', compact('user', 'activities'));
    }

    public function settings()
    {
        $user = auth()->user();
        return view('admin.profile.settings', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        // Simpan data lama untuk log
        $oldData = $user->only(['name', 'email', 'jenis_kelamin', 'tanggal_lahir', 'no_telepon', 'alamat']);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ]);

        // Update data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->no_telepon = $request->no_telepon;
        $user->alamat = $request->alamat;
        $user->save();

        // Log activity
        $newData = $user->only(['name', 'email', 'jenis_kelamin', 'tanggal_lahir', 'no_telepon', 'alamat']);
        $user->logActivity(
            'update_profile',
            'Memperbarui informasi profile',
            $oldData,
            $newData
        );

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diperbarui',
            'data' => $user
        ]);
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();
        $oldPhoto = $user->foto;

        // Hapus foto lama
        if ($oldPhoto && Storage::disk('public')->exists($oldPhoto)) {
            Storage::disk('public')->delete($oldPhoto);
        }

        // Upload foto baru
        $path = $request->file('photo')->store('profile-photos', 'public');
        $user->foto = $path;
        $user->save();

        // Log activity
        $user->logActivity(
            'update_photo',
            'Memperbarui foto profile'
        );

        return response()->json([
            'success' => true,
            'message' => 'Foto profile berhasil diperbarui',
            'photo_url' => Storage::url($path)
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            // Log failed attempt
            $user->logActivity(
                'change_password',
                'Percobaan ganti password gagal - password saat ini salah',
                null,
                null,
                'failed'
            );
            
            return response()->json([
                'success' => false,
                'errors' => ['current_password' => ['Password saat ini tidak sesuai']]
            ], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        // Log success
        $user->logActivity(
            'change_password',
            'Berhasil mengubah password'
        );

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah'
        ]);
    }
}
