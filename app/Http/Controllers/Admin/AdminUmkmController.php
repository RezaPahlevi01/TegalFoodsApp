<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminUmkmController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $umkms = User::with('umkm')
                    ->where('role', 'umkm')
                    ->when($search, function ($q) use ($search) {
                        $q->where(function ($q2) use ($search) {
                            $q2->where('name', 'ilike', "%{$search}%")
                               ->orWhere('email', 'ilike', "%{$search}%")
                               ->orWhere('nik', 'ilike', "%{$search}%")
                               ->orWhereHas('umkm', function ($q3) use ($search) {
                                   $q3->where('nib', 'ilike', "%{$search}%")
                                      ->orWhere('nama_umkm', 'ilike', "%{$search}%");
                               });
                        });
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(10)
                    ->appends(['search' => $search]);

        return view('admin.umkm.index', compact('umkms', 'search'));
    }

    public function create()
    {
        return view('admin.umkm.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'               => 'required|string|max:255',
            'nik'                => 'required|string|digits:16|unique:users,nik',
            'foto_ktp'           => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'email'              => 'required|email|max:255|unique:users,email',
            'password'           => 'required|string|min:6|confirmed',
            'nib'                => 'required|string|max:50|unique:umkms,nib',
            'dokumen_nib'        => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'nama_umkm'          => 'required|string|max:255',
            'deskripsi'          => 'nullable|string',
            'nomor_whatsapp'     => 'required|numeric|digits_between:10,15',
            'alamat'             => 'required|string',
            'logo'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'latitude'           => 'nullable|numeric|between:-90,90',
            'longitude'          => 'nullable|numeric|between:-180,180',
        ]);

        DB::transaction(function () use ($data, $request): void {
            $fotoKtpPath = null;
            if ($request->hasFile('foto_ktp')) {
                $fotoKtpPath = $request->file('foto_ktp')->store('ktp', 'public');
            }

            $dokumenNibPath = null;
            if ($request->hasFile('dokumen_nib')) {
                $dokumenNibPath = $request->file('dokumen_nib')->store('dokumen-nib', 'public');
            }

            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
            }

            $user = User::create([
                'name'      => $data['name'],
                'nik'       => $data['nik'],
                'foto_ktp'  => $fotoKtpPath,
                'email'     => $data['email'],
                'password'  => Hash::make($data['password']),
                'role'      => 'umkm',
                'status'    => 'active',
            ]);

            Umkm::create([
                'user_id'         => $user->id,
                'nib'             => $data['nib'],
                'dokumen_nib'     => $dokumenNibPath,
                'nama_umkm'       => $data['nama_umkm'],
                'nama_pemilik'    => $data['name'],
                'deskripsi'       => $data['deskripsi'] ?? null,
                'nomor_whatsapp'  => $data['nomor_whatsapp'],
                'alamat'          => $data['alamat'],
                'logo_url'        => $logoPath,
                'latitude'        => $data['latitude'] ?? null,
                'longitude'       => $data['longitude'] ?? null,
            ]);
        });

        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil ditambahkan');
    }

    public function show(User $umkm)
    {
        $umkm->load('umkm');
        return view('admin.umkm.show', compact('umkm'));
    }

    public function edit($id)
    {
        $umkm = User::with('umkm')->where('role', 'umkm')->findOrFail($id);
        return view('admin.umkm.edit', compact('umkm'));
    }

    public function update(Request $request, User $umkm)
    {
        $data = $request->validate([
            'name'               => 'required|string|max:255',
            'nik'                => ['required', 'string', 'digits:16', Rule::unique('users', 'nik')->ignore($umkm->id)],
            'foto_ktp'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email'              => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($umkm->id)],
            'password'           => 'nullable|string|min:6|confirmed',
            'nib'                => ['required', 'string', 'max:50', Rule::unique('umkms', 'nib')->ignore($umkm->umkm?->id, 'id')],
            'dokumen_nib'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'nama_umkm'          => 'required|string|max:255',
            'deskripsi'          => 'nullable|string',
            'nomor_whatsapp'     => 'required|numeric|digits_between:10,15',
            'alamat'             => 'required|string',
            'logo'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'latitude'           => 'nullable|numeric|between:-90,90',
            'longitude'          => 'nullable|numeric|between:-180,180',
        ]);

        DB::transaction(function () use ($umkm, $data, $request): void {
            $userData = [
                'name'  => $data['name'],
                'nik'   => $data['nik'],
                'email' => $data['email'],
            ];

            if (!empty($data['password'])) {
                $userData['password'] = Hash::make($data['password']);
            }

            if ($request->hasFile('foto_ktp')) {
                if ($umkm->foto_ktp) {
                    Storage::disk('public')->delete($umkm->foto_ktp);
                }
                $userData['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
            }

            $umkm->update($userData);

            $umkmData = [
                'nib'             => $data['nib'],
                'nama_umkm'       => $data['nama_umkm'],
                'nama_pemilik'    => $data['name'],
                'deskripsi'       => $data['deskripsi'] ?? null,
                'nomor_whatsapp'  => $data['nomor_whatsapp'],
                'alamat'          => $data['alamat'],
                'latitude'        => $data['latitude'] ?? null,
                'longitude'       => $data['longitude'] ?? null,
            ];

            if ($request->hasFile('dokumen_nib')) {
                if ($umkm->umkm && $umkm->umkm->dokumen_nib) {
                    Storage::disk('public')->delete($umkm->umkm->dokumen_nib);
                }
                $umkmData['dokumen_nib'] = $request->file('dokumen_nib')->store('dokumen-nib', 'public');
            }

            if ($request->hasFile('logo')) {
                if ($umkm->umkm && $umkm->umkm->logo_url) {
                    Storage::disk('public')->delete($umkm->umkm->logo_url);
                }
                $umkmData['logo_url'] = $request->file('logo')->store('logos', 'public');
            }

            if ($umkm->umkm) {
                $umkm->umkm->update($umkmData);
            } else {
                $umkmData['user_id'] = $umkm->id;
                Umkm::create($umkmData);
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
