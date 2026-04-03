<?php

namespace App\Http\Controllers\Siswa\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;

class ResetPasswordController extends Controller
{
    /**
     * Display the password reset form.
     *
     * @return \Illuminate\View\View
     */
    public function showResetForm()
    {
        if (!session('otp_verified') || !session('reset_email')) {
            return redirect()->route('siswa.password.request');
        }
        return view('siswa.auth.passwords.reset');
    }

    /**
     * Handle a password reset request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $email = session('reset_email');
        if (!$email || !session('otp_verified')) {
            return redirect()->route('siswa.password.request');
        }

        $siswa = Siswa::where('email', $email)->first();
        if (!$siswa) {
            return redirect()->route('siswa.password.request');
        }

        $siswa->password = Hash::make($request->password);
        $siswa->save();

        // Clear OTP and reset session
        DB::table('password_otp_resets')->where('email', $email)->delete();
        session()->forget(['reset_email', 'otp_verified']);

        return redirect()->route('siswa.login')->with('success', 'Password berhasil direset, silakan login kembali');
    }
}
