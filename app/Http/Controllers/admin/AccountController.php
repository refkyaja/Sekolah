<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AccountController extends Controller
{
    /**
     * Display a listing of all accounts.
     */
    public function index(Request $request)
    {
        // Cek akses
        if (!in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403, 'Unauthorized access.');
        }

        $query = User::query();
        
        // Filter berdasarkan role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Filter berdasarkan status aktif
        if ($request->filled('status') && Schema::hasColumn('users', 'is_active')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }
        
        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $users = $query->paginate(15)->withQueryString();
        
        // Statistik
        $totalAccounts = User::count();
        $totalActive = User::where('is_active', true)->count();
        $totalInactive = User::where('is_active', false)->count();
        $totalByRole = [
            'admin' => User::where('role', 'admin')->count(),
            'kepala_sekolah' => User::where('role', 'kepala_sekolah')->count(),
            'operator' => User::where('role', 'operator')->count(),
            'guru' => User::where('role', 'guru')->count(),
        ];
        
        return view('admin.accounts.index', compact(
            'users', 
            'totalAccounts', 
            'totalActive', 
            'totalInactive',
            'totalByRole'
        ));
    }

    /**
     * Show form for creating new account.
     */
    public function create()
    {
        if (!in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403);
        }
        return view('admin.accounts.create');
    }

    /**
     * Store a newly created account.
     */
    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,kepala_sekolah,operator,guru',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Akun berhasil dibuat.');
    }

    /**
     * Display the specified account.
     */
    public function show(User $account)
    {
        if (!in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403);
        }
        return view('admin.accounts.show', compact('account'));
    }

    /**
     * Show form for editing account.
     */
    public function edit(User $account)
    {
        if (!in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403);
        }
        return view('admin.accounts.edit', compact('account'));
    }

    /**
     * Update the specified account.
     */
    public function update(Request $request, User $account)
    {
        if (!in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($account->id),
            ],
            'role' => 'required|in:admin,kepala_sekolah,operator,guru',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:100', 
            'tanggal_lahir' => 'nullable|date',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $account->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir, 
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Reset password for an account.
     */
    public function resetPassword(Request $request, User $account)
    {
        if (!in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403);
        }

        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $account->password = Hash::make($request->new_password);
        $account->save();

        return redirect()->route('admin.accounts.show', $account)
            ->with('success', 'Password berhasil direset.');
    }

    /**
     * Toggle account active status.
     */
    public function toggleStatus(User $account)
    {
        if (!in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403);
        }

        // ❌ TIDAK BISA nonaktifkan akun sendiri
        if ($account->id === auth()->id()) {
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $account->is_active = !$account->is_active;
        $account->save();

        $status = $account->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.accounts.index')
            ->with('success', "Akun {$account->name} berhasil {$status}.");
    }

    /**
     * Delete account.
     */
    public function destroy(User $account)
    {
        if (!in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403);
        }

        // ❌ TIDAK BISA hapus akun sendiri
        if ($account->id === auth()->id()) {
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        $name = $account->name;
        $account->delete();

        return redirect()->route('admin.accounts.index')
            ->with('success', "Akun {$name} berhasil dihapus.");
    }

    /**
     * Bulk actions on accounts.
     */
    public function bulkAction(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403);
        }

        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        // ❌ Hapus akun sendiri dari array
        $userIds = array_diff($request->user_ids, [auth()->id()]);

        if (empty($userIds)) {
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Tidak ada akun yang dipilih untuk diproses (akun sendiri tidak dapat diproses).');
        }

        $count = count($userIds);

        switch ($request->action) {
            case 'activate':
                User::whereIn('id', $userIds)->update(['is_active' => true]);
                $message = "{$count} akun berhasil diaktifkan.";
                break;
                
            case 'deactivate':
                User::whereIn('id', $userIds)->update(['is_active' => false]);
                $message = "{$count} akun berhasil dinonaktifkan.";
                break;
                
            case 'delete':
                User::whereIn('id', $userIds)->delete();
                $message = "{$count} akun berhasil dihapus.";
                break;
                
            default:
                return redirect()->route('admin.accounts.index');
        }

        return redirect()->route('admin.accounts.index')
            ->with('success', $message);
    }
}