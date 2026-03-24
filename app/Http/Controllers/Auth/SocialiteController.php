<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google_admin')->redirect();
    }

    public function handleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google_admin')->user();

            // Check if user exists by provider_id
            $user = User::where('provider', 'google')
                ->where('provider_id', $googleUser->getId())
                ->first();

            if ($user) {
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
            }

            // Check if user exists by email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Link account
                $user->update([
                    'provider' => 'google',
                    'provider_id' => $googleUser->getId(),
                    'foto' => $user->foto ?? $googleUser->getAvatar(),
                ]);

                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
            }

            // Create new user (Auto register based on request)
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
                'foto' => $googleUser->getAvatar(),
                'password' => Hash::make(Str::random(16)),
                'role' => 'guru', // Default role for social signup
                'is_active' => true,
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('dashboard')->with('success', 'Akun berhasil dibuat dengan Google!');

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Terjadi kesalahan saat otentikasi dengan Google: ' . $e->getMessage(),
            ]);
        }
    }
}
