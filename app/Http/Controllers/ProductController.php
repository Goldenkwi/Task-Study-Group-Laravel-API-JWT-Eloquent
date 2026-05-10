<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
class ProductController extends Controller
{
/**
     * Display a listing of the resource.
     */
public function index(Request $request)
    {
$query = Product::query();
if ($request->include === 'category') {
$query->with('category');
        }
if ($request->filled('search')) {
$query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
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
'name'          => 'required|string|max:255',
'description'   => 'nullable|string|max:255',
'price'         => 'required|integer|min:0',
'stock'         => 'nullable|integer|min:0',
'internal_note' => 'nullable|string',
'category_id'   => 'required|exists:categories,id'
        ]);
$product = Product::create($validated);
return response()->json([
'success'   => true,
'data'      => $product->load('category')
        ], 201);
    }
/**
     * Display the specified resource.
     */
public function show(Request $request, string $id)
    {
$query = Product::query();
if ($request->include === 'category') {
$query->with('category');
        }
$product = $query->findOrFail($id);
return response()->json([
'status' => 'success',
'data'   => $product
        ]);
    }
/**
     * Update the specified resource in storage.
     */
public function update(Request $request, string $id)
    {
$product = Product::findOrFail($id);
$validated = $request->validate([
'name'          => 'sometimes|string|max:255',
'description'   => 'nullable|string',
'price'         => 'sometimes|integer|min:0',
'stock'         => 'nullable|integer|min:0',
'internal_note' => 'nullable|string',
'category_id'   => 'sometimes|exists:categories,id'
        ]);
$product->update($validated);
return response()->json([
'status' => 'success',
'data'   => $product->load('category')
        ]);
    }
/**
     * Remove the specified resource from storage.
     */
public function destroy(string $id)
    {
$product = Product::findOrFail($id);
$product->delete();
return response()->json([
'status'  => 'success',
'message' => 'Product deleted successfully'
        ]);
    }
}