<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'data' => $categories,
            'message' => 'Categories retrieved successfully',
            'status' => 200
        ], 200);
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'value' => ['nullable', 'numeric'],
            'color' => ['nullable', 'string', 'max:50'],
        ]);

        $input['created_by'] = auth()->id();
        $input['updated_by'] = auth()->id();

        $category = Category::create($input);

        return response()->json([
            'data' => $category,
            'message' => 'Category created successfully',
            'status' => 201
        ], 201);
    }

    public function show(Category $category)
    {
        return response()->json([
            'data' => $category,
            'message' => 'Category retrieved successfully',
            'status' => 200
        ], 200);
    }

    public function update(Request $request, Category $category)
    {
        $input = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'value' => ['sometimes', 'nullable', 'numeric'],
            'color' => ['sometimes', 'nullable', 'string', 'max:50'],
        ]);

        $input['updated_by'] = auth()->id();
        $category->update($input);

        return response()->json([
            'data' => $category,
            'message' => 'Category updated successfully',
            'status' => 200
        ], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully',
            'status' => 200
        ], 200);
    }
}
