<?php

namespace App\Http\Controllers\Siswa\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Siswa;
use App\Notifications\SiswaOtpNotification;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Show the application's password reset link request form.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('siswa.auth.passwords.email');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:siswas,email'],
        ], [
            'email.exists' => 'Email tidak terdaftar.',
        ]);

        $otp = rand(100000, 999999);
        $email = $request->email;

        DB::table('password_otp_resets')->updateOrInsert(
            ['email' => $email],
            [
                'code' => $otp,
                'expires_at' => Carbon::now()->addMinutes(5),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        $siswa = Siswa::where('email', $email)->first();
        $siswa->notify(new SiswaOtpNotification($otp));

        session(['reset_email' => $email]);

        return redirect()->route('siswa.password.verify')->with('status', 'Kode OTP telah dikirim ke email Anda.');
    }

    /**
     * Show the OTP verification form.
     *
     * @return \Illuminate\View\View
     */
    public function showOtpForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('siswa.password.request');
        }
        return view('siswa.auth.passwords.otp');
    }

    /**
     * Handle OTP verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $email = session('reset_email');
        if (!$email) {
            return redirect()->route('siswa.password.request');
        }

        $otpRecord = DB::table('password_otp_resets')
            ->where('email', $email)
            ->where('code', $request->otp)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kedaluwarsa.']);
        }

        session(['otp_verified' => true]);

        return redirect()->route('siswa.password.new');
    }
}
