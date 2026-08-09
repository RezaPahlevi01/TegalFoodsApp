<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;

class AdminSliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'judul' => 'nullable|string|max:255',
        ]);

        $url = null;
        if ($request->hasFile('gambar')) {
            $cloudinary = app(CloudinaryService::class);
            $url = $cloudinary->upload($request->file('gambar'), 'sliders');
        }

        Slider::create([
            'judul' => $request->judul,
            'gambar' => $url,
        ]);

        return redirect()
            ->route('admin.slider.index')
            ->with('success', 'Slider berhasil ditambahkan');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();

        return back()->with('success', 'Slider dihapus');
    }
}
