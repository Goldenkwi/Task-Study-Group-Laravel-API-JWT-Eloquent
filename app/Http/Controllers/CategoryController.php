<?php

namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::withCount('products');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->include === 'products') {
            $query->with('products');
        }

        return response()->json([
            'status' => 'success',
            'data'   => $query->paginate($request->get('per_page', 10))
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string'
        ]);

        $category = Category::create($validated);

        return response()->json([
            'status' => 'success',
            'data'   => $category
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $query = Category::withCount('products');

        if ($request->include === 'products') {
            $query->with('products');
        }

        $category = $query->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data'   => $category
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string'
        ]);

        $category->update($validated);

        return response()->json([
            'status' => 'success',
            'data'   => $category
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        if ($category->products()->exists()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Category masih digunakan oleh ' . $category->products()->count() . ' product'
            ], 422);
        }

        $category->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Category deleted successfully'
        ]);
    }

}
