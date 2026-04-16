<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
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
            'nomor_whatsapp' => 'required'
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
            'nomor_whatsapp' => $request->nomor_whatsapp
        ]);

        return redirect()
            ->route('umkm.login')
            ->with('success', 'Pendaftaran berhasil. Menunggu verifikasi admin.');
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
}