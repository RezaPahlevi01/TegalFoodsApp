<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodBlog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminFoodBlogController extends Controller
{
    public function index()
    {
        $blogs = FoodBlog::latest()->paginate(10);
        return view('admin.foodblog.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.foodblog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image',
            'status' => 'required'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('food-blog', 'public');
        }

        FoodBlog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image' => $imagePath,
            'status' => $request->status
        ]);

        return redirect()->route('admin.foodblog.index')
            ->with('success', 'Artikel berhasil ditambahkan');
    }

    public function edit(FoodBlog $foodblog)
    {
        return view('admin.foodblog.edit', compact('foodblog'));
    }

    public function update(Request $request, FoodBlog $foodblog)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'status' => 'required'
        ]);

        $foodblog->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->status
        ]);

        return redirect()->route('admin.foodblog.index')
            ->with('success', 'Artikel berhasil diupdate');
    }

    public function destroy(FoodBlog $foodblog)
    {
        $foodblog->delete();

        return back()->with('success', 'Artikel dihapus');
    }

    public function published($id)
    {
        $blog = FoodBlog::findOrFail($id);

        $blog->update(['status' => 'published']);

        return response()->json(['status' => 'published', 'message' => 'Artikel berhasil dipublikasikan']);
    }

    public function draft($id)
    {
        $blog = FoodBlog::findOrFail($id);

        $blog->update(['status' => 'draft']);

        return response()->json(['status' => 'draft', 'message' => 'Artikel berhasil dinonaktifkan']);
    }
}
