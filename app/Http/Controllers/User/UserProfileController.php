<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;


class UserProfileController extends Controller
{
    public function update(Request $request)
{
    $request->validate([
        'name'=>'required',
        'nomor_telepon'=>'required',
        'alamat'=>'required',
        'latitude'=>'nullable|numeric',
        'longitude'=>'nullable|numeric'
    ]);

    $user=Auth::user();

    $user->update([
        'name'=>$request->name
    ]);

    UserProfile::updateOrCreate(
        ['user_id' => $user->id],
        [
            'nama_lengkap'  => $request->name,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat'        => $request->alamat,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude
        ]
    );

    return back()->with('success','Profile berhasil diperbarui.');
}
}
