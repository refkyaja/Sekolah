<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class SiswaAccountController extends Controller
{
    /**
     * Display a listing of siswa accounts.
     */
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $query = Siswa::query()->with('spmb');

        // Search name/email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        // Filter Registration Presence
        if ($request->filled('registration')) {
            if ($request->registration === 'yes') {
                $query->whereNotNull('spmb_id');
            } else {
                $query->whereNull('spmb_id');
            }
        }

        $siswas = $query->latest()->paginate(15)->withQueryString();

        return view('admin.siswa-accounts.index', compact('siswas'));
    }

    /**
     * Display the specified account.
     */
    public function show(Siswa $siswa_account)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $siswa_account->load('spmb');
        return view('admin.siswa-accounts.show', [
            'account' => $siswa_account
        ]);
    }

    /**
     * Show form for editing.
     */
    public function edit(Siswa $siswa_account)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.siswa-accounts.edit', [
            'account' => $siswa_account
        ]);
    }

    /**
     * Update account.
     */
    public function update(Request $request, Siswa $siswa_account)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('siswas')->ignore($siswa_account->id),
            ],
            'no_hp_ortu' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $siswa_account->update([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_hp_ortu' => $request->no_hp_ortu,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.siswa-accounts.show', $siswa_account)
            ->with('success', 'Akun calon siswa berhasil diperbarui.');
    }

    /**
     * Reset password.
     */
    public function resetPassword(Request $request, Siswa $siswa_account)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $siswa_account->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil direset.');
    }

    /**
     * Toggle status.
     */
    public function toggleStatus(Siswa $siswa_account)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $siswa_account->is_active = !$siswa_account->is_active;
        $siswa_account->save();

        $status = $siswa_account->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun {$siswa_account->nama_lengkap} berhasil {$status}.");
    }

    /**
     * Delete account.
     */
    public function destroy(Siswa $siswa_account)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $name = $siswa_account->nama_lengkap;
        $siswa_account->delete();

        return redirect()->route('admin.siswa-accounts.index')
            ->with('success', "Akun {$name} berhasil dihapus.");
    }
}
