<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function authenticateAdmin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $credentials['role'] = 'admin';

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Login admin gagal',
        ]);
    }

    public function authenticateUmkm(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $credentials['role'] = 'umkm';

        if (Auth::guard('umkm')->attempt($credentials)) {

            $user = Auth::guard('umkm')->user();

            if ($user->status !== 'active') {
                Auth::guard('umkm')->logout();

                return back()->withErrors([
                    'email' => 'Akun belum aktif'
                ]);
            }

            $request->session()->regenerate();
            return redirect()->route('umkm.dashboard');
        }

        return back()->withErrors([
            'email' => 'Login UMKM gagal',
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

            // USER
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',

            // UMKM
            'nama_umkm' => 'required',
            'nama_pemilik' => 'required',
            'alamat' => 'required',
            'nomor_whatsapp' => 'required'
        ]);

        // SIMPAN USER
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            'role' => 'umkm',
            'status' => 'pending'
        ]);

        // SIMPAN UMKM
        Umkm::create([
            'user_id' => $user->id,
            'nama_umkm' => $request->nama_umkm,
            'nama_pemilik' => $request->nama_pemilik,
            'alamat' => $request->alamat,
            'nomor_whatsapp' => $request->nomor_whatsapp
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Pendaftaran berhasil. Menunggu verifikasi admin.');
    }

    // ======================
    // LOGOUT
    // ======================

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login-admin');
    }

    public function logoutUmkm(Request $request)
    {
        Auth::guard('umkm')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
