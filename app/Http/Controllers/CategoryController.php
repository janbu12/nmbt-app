<?php

namespace App\Http\Controllers;

// use App\Models\Category;

use App\Models\CategoryModel;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = CategoryModel::withCount('products')
            ->when($search, function($query, $search) {
            $query->where('category_name', 'like', "%$search%");
            })
            ->orderBy('category_name')
            ->get();
            
        return view('admin.category', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        CategoryModel::create([
            'category_name' => $request->category_name,
            'created_at' => now(),
            'update_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Category added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        $category = CategoryModel::findOrFail($id);
        $category->update([
            'category_name' => $request->category_name,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Category updated successfully!');
    }

}
