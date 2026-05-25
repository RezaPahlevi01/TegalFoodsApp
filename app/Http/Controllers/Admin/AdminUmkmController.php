<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
            'email'      => 'required|email|max:255|unique:users,email',
        ]);

        DB::transaction(function () use ($data): void {
            $user = User::create(array_merge($data, ['role' => 'umkm', 'status' => 'active']));

            Umkm::create([
                'user_id' => $user->id,
                'nama_umkm' => $user->name,
                'nama_pemilik' => $user->name,
                'alamat' => '-',
                'nomor_whatsapp' => '-',
            ]);
        });

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
            'email'      => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($umkm->id)],
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        DB::transaction(function () use ($umkm, $data): void {
            $umkm->update($data);

            if (!$umkm->umkm) {
                Umkm::create([
                    'user_id' => $umkm->id,
                    'nama_umkm' => $umkm->name,
                    'nama_pemilik' => $umkm->name,
                    'alamat' => '-',
                    'nomor_whatsapp' => '-',
                ]);
            }
        });

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
