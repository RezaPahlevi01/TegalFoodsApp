<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Umkm;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Throwable;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    private const OTP_TTL_MINUTES = 10;


    //LOGIN USER
    public function showLoginUser()
    {
        return view('auth.login-user');
    }

    public function showRegisterUser()
    {
        return view('auth.register-user');
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'nomor_telepon' => 'required|numeric|digits_between:10,15'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'status' => 'active',
            'email_verified_at' => now()
        ]);

        UserProfile::create([

            'user_id'=>$user->id,

            'nama_lengkap'=>$request->name,

            'nomor_telepon'=>$request->nomor_telepon

        ]);

        return redirect()
            ->route('user.login')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function authenticateUser(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role !== 'user') {

                Auth::logout();

                return back()->withErrors([
                    'email' => 'Akun ini bukan akun pembeli'
                ]);
            }

            return redirect()->route('welcome');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah'
        ]);
    }

    public function redirectUserGoogle()
    {
        return Socialite::driver('google')
            ->redirectUrl(route('user.google.callback'))
            ->redirect();
    }

    public function handleUserGoogleCallback(Request $request)
    {
        try {

            $googleUser = Socialite::driver('google')
                ->redirectUrl(route('user.google.callback'))
                ->stateless()
                ->user();

        } catch (Throwable $e) {

            return redirect()
                ->route('user.login')
                ->withErrors([
                    'email' => 'Login Google gagal'
                ]);
        }

        $user = User::where(
            'email',
            $googleUser->email
        )->first();

        if ($user && $user->role !== 'user') {

            return redirect()
                ->route('user.login')
                ->withErrors([
                    'email' => 'Email ini sudah digunakan akun UMKM/Admin'
                ]);
        }

        if (!$user) {

            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => Hash::make(Str::random(32)),
                'role' => 'user',
                'status' => 'active',
                'google_id' => $googleUser->id,
                'email_verified_at' => now()
            ]);
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('welcome');
    }


    // ======================
    // LOGIN ADMIN
    // ======================
    public function authenticateAdmin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::guard('admin')->user(); // ✅ BENAR

            if (!$user || $user->role !== 'admin') {
                Auth::guard('admin')->logout();
                return back()->withErrors(['email' => 'Bukan admin']);
            }

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Login admin gagal'
        ]);
    }

    // ======================
    // LOGIN UMKM
    // ======================
    public function authenticateUmkm(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('umkm')->attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::guard('umkm')->user(); // ✅ WAJIB guard

            if (!$user || $user->role !== 'umkm') {
                Auth::guard('umkm')->logout();
                return back()->withErrors(['email' => 'Bukan UMKM']);
            }

            if ($user->status === 'pending') {
                $this->issueOtpForUser($user);
                Auth::guard('umkm')->logout();

                session(['otp_email' => $user->email]);

                return redirect()
                    ->route('otp.form')
                    ->with('success', 'Akun perlu verifikasi OTP. Kode baru sudah dikirim.');
            }

            if ($user->status !== 'active') {
                Auth::guard('umkm')->logout();
                return back()->withErrors(['email' => 'Belum aktif']);
            }

            return redirect()->route('umkm.dashboard');
        }

        return back()->withErrors([
            'email' => 'Login gagal'
        ]);
    }

    // ======================
    // REGISTER UMKM
    // ======================
    public function showRegisterUmkm()
    {
        return view('auth.register-umkm');
    }

    public function registerUmkm(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',

            'nama_umkm' => 'required',
            'nama_pemilik' => 'required',
            'alamat' => 'required',
            'nomor_whatsapp' => 'required',
            'foto_qris' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'umkm',
            'status' => 'pending'
        ]);

        Umkm::create([
            'user_id' => $user->id,
            'nama_umkm' => $request->nama_umkm,
            'nama_pemilik' => $request->nama_pemilik,
            'alamat' => $request->alamat,
            'nomor_whatsapp' => $request->nomor_whatsapp,
            'foto_qris' => $request->file('foto_qris')->store('qris', 'public')
        ]);

        $this->issueOtpForUser($user);
        session(['otp_email' => $user->email]);

        return redirect()
            ->route('otp.form')
            ->with('success', 'Pendaftaran berhasil. OTP verifikasi telah dikirim ke email.');
    }

    public function otpForm()
    {
        if (!session('otp_email')) {
            return redirect()->route('umkm.login')
                ->withErrors(['email' => 'Silakan login atau daftar terlebih dahulu.']);
        }

        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('umkm.login')
                ->withErrors(['email' => 'Sesi OTP tidak valid. Silakan login ulang.']);
        }

        $user = User::where('email', $email)->where('role', 'umkm')->first();
        if (!$user) {
            return redirect()->route('umkm.login')
                ->withErrors(['email' => 'Akun UMKM tidak ditemukan.']);
        }

        if (
            !$user->otp_code ||
            !$user->otp_expired_at ||
            Carbon::now()->greaterThan(Carbon::parse($user->otp_expired_at))
        ) {
            return back()->withErrors(['otp' => 'OTP sudah kadaluarsa. Silakan kirim ulang.']);
        }

        if ($request->otp !== $user->otp_code) {
            return back()->withErrors(['otp' => 'Kode OTP tidak sesuai.']);
        }

        $user->update([
            'status' => 'active',
            'otp_code' => null,
            'otp_expired_at' => null,
            'email_verified_at' => Carbon::now(),
        ]);

        session()->forget('otp_email');
        Auth::guard('umkm')->login($user);
        $request->session()->regenerate();

        return redirect()->route('umkm.dashboard')
            ->with('success', 'Verifikasi OTP berhasil. Selamat datang!');
    }

    public function resendOtp()
    {
        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('umkm.login')
                ->withErrors(['email' => 'Sesi OTP tidak ditemukan.']);
        }

        $user = User::where('email', $email)->where('role', 'umkm')->first();
        if (!$user) {
            return redirect()->route('umkm.login')
                ->withErrors(['email' => 'Akun UMKM tidak ditemukan.']);
        }

        $this->issueOtpForUser($user);

        return back()->with('success', 'OTP baru sudah dikirim ke email Anda.');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->redirectUrl(route('umkm.google.callback'))
            ->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl(route('umkm.google.callback'))
                ->stateless()
                ->user();
        } catch (Throwable $e) {
            Log::error('Google login failed.', ['error' => $e->getMessage()]);
            return redirect()->route('umkm.login')
                ->withErrors(['email' => 'Login Google gagal. Coba lagi.']);
        }

        $existingUserByGoogle = User::where('google_id', $googleUser->id)->first();
        $existingUserByEmail = User::where('email', $googleUser->email)->first();

        $user = $existingUserByGoogle ?? $existingUserByEmail;

        if ($user && $user->role !== 'umkm') {
            return redirect()->route('umkm.login')
                ->withErrors(['email' => 'Email ini terdaftar sebagai akun non-UMKM.']);
        }

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->name ?: 'Mitra UMKM',
                'email' => $googleUser->email,
                'password' => Hash::make(Str::random(32)),
                'role' => 'umkm',
                'status' => 'active',
                'google_id' => $googleUser->id,
                'email_verified_at' => Carbon::now(),
            ]);

            Umkm::create([
                'user_id' => $user->id,
                'nama_umkm' => $googleUser->name ?: 'UMKM Baru',
                'nama_pemilik' => $googleUser->name ?: 'Pemilik UMKM',
                'alamat' => '-',
                'nomor_whatsapp' => '-',
            ]);
        } else {
            $user->update([
                'google_id' => $googleUser->id,
                'email_verified_at' => $user->email_verified_at ?: Carbon::now(),
            ]);
        }

        Auth::guard('umkm')->login($user);
        $request->session()->regenerate();

        return redirect()->route('umkm.dashboard');
    }

    public function logoutUser(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login');
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();

        if (!Auth::guard('umkm')->check()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('admin.login');
    }

    public function logoutUmkm(Request $request)
    {
        Auth::guard('umkm')->logout();

        if (!Auth::guard('admin')->check()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('umkm.login');
    }

    private function issueOtpForUser(User $user): void
    {
        $otp = (string) random_int(100000, 999999);

        $user->update([
            'otp_code' => $otp,
            'otp_expired_at' => Carbon::now()->addMinutes(self::OTP_TTL_MINUTES),
        ]);

        try {
            Mail::raw(
                "Kode OTP verifikasi akun UMKM Anda adalah: {$otp}. Berlaku selama " . self::OTP_TTL_MINUTES . " menit.",
                function ($message) use ($user): void {
                    $message->to($user->email)
                        ->subject('OTP Verifikasi Akun UMKM');
                }
            );
        } catch (Throwable $e) {
            Log::warning('OTP email could not be sent.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // cek email ada di user table (user + umkm)
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar'
            ]);
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        $resetLink = url('/reset-password/'.$token.'?email='.$request->email);

        Mail::send('emails.reset-password', [
            'resetLink' => $resetLink,
            'email' => $request->email
        ], function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Reset Password - TegalFood');
        });

        return back()->with('success', 'Link reset password sudah dikirim ke email');
    }

    // private function sendResetEmail($email, $token)
    // {
    //     $resetLink = url('/reset-password/'.$token.'?email='.$email);

    //     Mail::send('emails.reset-password', [
    //         'resetLink' => $resetLink,
    //         'email' => $email
    //     ], function ($message) use ($email) {
    //         $message->to($email)
    //             ->subject('Reset Password - TegalFood');
    //     });
    // }

    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record) {
            return back()->withErrors(['email' => 'Token tidak valid']);
        }

        if (!Hash::check($request->token, $record->token)) {
            return back()->withErrors(['token' => 'Token salah']);
        }

        $user = User::where('email', $request->email)->first();

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('user.login')
            ->with('success', 'Password berhasil direset');
    }
}