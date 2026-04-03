<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function login()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }

        // If already logged in, redirect to dashboard
        if (Auth::guard('siswa')->check()) {
            return redirect()->route('siswa.dashboard');
        }

        if (request('redirect')) {
            request()->session()->put('url.intended', request('redirect'));
        }
        
        return view('siswa.auth.login');
    }

    /**
     * Show the register form.
     */
    public function register()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }

        // If already logged in, redirect to dashboard
        if (Auth::guard('siswa')->check()) {
            return redirect()->route('siswa.dashboard');
        }

        if (request('redirect')) {
            request()->session()->put('url.intended', request('redirect'));
        }
        
        return view('siswa.auth.register');
    }

    /**
     * Handle registration.
     */
    public function storeRegister(Request $request)
    {
        $request->validate([
            'nama_ortu' => ['required', 'string', 'max:255'],
            'nama_siswa' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:siswas,email'],
            'whatsapp' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $activeTahunAjaran = TahunAjaran::where('is_aktif', true)->first() ?? TahunAjaran::latest()->first();
        $tahunAjaranValue = $activeTahunAjaran ? $activeTahunAjaran->tahun_ajaran : date('Y') . '/' . (date('Y') + 1);

        $siswa = Siswa::create([
            'nama_lengkap' => $request->nama_siswa,
            'nama_ayah' => $request->nama_ortu,
            'email' => $request->email,
            'no_hp_ortu' => $request->whatsapp,
            'password' => Hash::make($request->password),
            'status_siswa' => 'aktif',
            'tanggal_masuk' => Carbon::now(),
            'tahun_ajaran_id' => $activeTahunAjaran ? $activeTahunAjaran->id : null,
            'tahun_ajaran' => $tahunAjaranValue,
        ]);

        Auth::guard('siswa')->login($siswa);
        $request->session()->forget('url.intended');
        $request->session()->regenerate();

        return redirect()->to(route('siswa.dashboard', [], false))->with('success', 'Pendaftaran berhasil! Selamat datang di TK Harapan Bangsa 1.');
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('siswa')->attempt($credentials, $request->filled('remember-me'))) {
            $siswa = Auth::guard('siswa')->user();
            
            // Cek apakah akun aktif
            if (!$siswa->is_active) {
                Auth::guard('siswa')->logout();
                return back()->withErrors([
                    'email' => 'Akun Anda telah dinonaktifkan oleh administrator.',
                ]);
            }

            $request->session()->forget('url.intended');
            $request->session()->regenerate();

            return redirect()->to(route('siswa.dashboard', [], false));
        }

        return back()->withErrors([
            'email' => 'Informasi login yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::guard('siswa')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('siswa.login');
    }

    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if student exists by provider_id
            $siswa = Siswa::where('provider', 'google')
                ->where('provider_id', $googleUser->getId())
                ->first();

            if ($siswa) {
                // Cek apakah akun aktif
                if (!$siswa->is_active) {
                    return redirect()->route('siswa.login')->withErrors([
                        'email' => 'Akun Anda telah dinonaktifkan oleh administrator.',
                    ]);
                }
                
                // Log them in
                Auth::guard('siswa')->login($siswa);
                $request->session()->regenerate();
                return redirect()->intended(route('siswa.dashboard'));
            }

            // Check if student exists by email
            if ($googleUser->getEmail()) {
                $siswa = Siswa::where('email', $googleUser->getEmail())->first();

                if ($siswa) {
                    // Cek apakah akun aktif
                    if (!$siswa->is_active) {
                        return redirect()->route('siswa.login')->withErrors([
                            'email' => 'Akun Anda telah dinonaktifkan oleh administrator.',
                        ]);
                    }
                    // Update their provider info and log them in
                    $siswa->update([
                        'provider' => 'google',
                        'provider_id' => $googleUser->getId(),
                        'foto' => $siswa->foto ?? $googleUser->getAvatar(),
                    ]);

                    Auth::guard('siswa')->login($siswa);
                    $request->session()->regenerate();
                    return redirect()->intended(route('siswa.dashboard'));
                }
            }

            // Create new student record (Auto Signup)
            $activeTahunAjaran = TahunAjaran::where('is_aktif', true)->first() ?? TahunAjaran::latest()->first();
            $tahunAjaranValue = $activeTahunAjaran ? $activeTahunAjaran->tahun_ajaran : date('Y') . '/' . (date('Y') + 1);
            
            $siswa = Siswa::create([
                'nama_lengkap' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
                'foto' => $googleUser->getAvatar(),
                'password' => Hash::make(Str::random(16)),
                'status_siswa' => 'aktif',
                'tanggal_masuk' => Carbon::now(),
                'tahun_ajaran_id' => $activeTahunAjaran ? $activeTahunAjaran->id : null,
                'tahun_ajaran' => $tahunAjaranValue,
            ]);

            Auth::guard('siswa')->login($siswa);
            $request->session()->regenerate();

            return redirect()->route('siswa.dashboard')->with('success', 'Akun berhasil dibuat dengan Google! Silakan lengkapi profil Anda.');

        } catch (\Exception $e) {
            return redirect()->route('siswa.login')->withErrors([
                'username' => 'Terjadi kesalahan saat otentikasi dengan Google: ' . $e->getMessage(),
            ]);
        }
    }
}
