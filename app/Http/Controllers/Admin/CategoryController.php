<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // GET /api/v1/admin/categories
    public function index()
    {
        return response()->json(Category::all());
    }

    // POST /api/v1/admin/categories
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'icon' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $category = Category::create([
            'name'        => $request->name,
            'icon'        => $request->icon ?? '🔧',
            'description' => $request->description,
            'is_active'   => true,
        ]);

        return response()->json([
            'message'  => 'Catégorie créée',
            'category' => $category,
        ], 201);
    }

    // PUT /api/v1/admin/categories/{id}
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'icon' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $category->update($request->only('name', 'icon', 'description'));

        return response()->json([
            'message'  => 'Catégorie mise à jour',
            'category' => $category,
        ]);
    }

    // DELETE /api/v1/admin/categories/{id}
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['message' => 'Catégorie supprimée']);
    }
}