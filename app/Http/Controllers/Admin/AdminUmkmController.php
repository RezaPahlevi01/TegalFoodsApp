<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUmkmController extends Controller
{
    public function index()
    {
        $umkms = User::where('role', 'umkm')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('admin.umkm.index', compact('umkms'));
    }

    public function create()
    {
        return view('admin.umkm.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'password'   => 'required|string|min:6|confirmed',
            'role'       => 'required|string|in:umkm',
            'email'    => 'required|string|max:255',
        ]);

        User::create(array_merge($data, ['role' => 'umkm', 'status' => 'pending']));
        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil ditambahkan');
    }

    public function edit($id)
    {
        $umkm = User::where('role', 'umkm')->findOrFail($id);
        return view('admin.umkm.edit', compact('umkm'));
    }

    public function update(Request $request, User $umkm)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'password'   => 'nullable|string|min:6|confirmed',
            'role'       => 'required|string|in:umkm',
            'email'    => 'required|string|max:255',
        ]);

        $umkm->update($data);

        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil diperbarui');
    }

    public function destroy(User $umkm)
    {
        $umkm->delete();

        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil dihapus');
    }

    public function activate($id)
    {
        $user = User::where('role', 'umkm')->findOrFail($id);

        $user->update(['status' => 'active']);

        return response()->json(['status' => 'active', 'message' => 'Akun UMKM berhasil diaktifkan']);
    }

    public function deactivate($id)
    {
        $user = User::where('role', 'umkm')->findOrFail($id);

        $user->update(['status' => 'non-active']);

        return response()->json(['status' => 'non-active', 'message' => 'Akun UMKM berhasil dinonaktifkan']);
    }
}
