<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('user')->get();

        return response()->json([
            'code' => 200,
            'message' => 'Daftar Kategori Berhasil Diambil',
            'data' => $categories,
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:users,id',
        ]);

        $category = new Category([
            'name' => $validated['name'],
            'teacher_id' => $request->user()->id,
        ]);

        $category->save();

        return response()->json([
            'code' => 201,
            'message' => 'Kategori Berhasil Ditambahkan',
            'data' => $category,
        ], 201);
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return response()->json([
            'code' => 200,
            'message' => 'Kategori Berhasil Dihapus',
        ]);
    }


}