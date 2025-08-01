<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class CategoryController extends Controller
{
    public function index()
    {
 
        try {

            $category = Category::get();

            return response()->json([
                'category' => $category
            ]);

        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);

        }
    }

    public function store(CategoryStoreRequest $request)
    {
        
        try {

            $category = Category::create([
                'name' => $request['name'],
                'is_active' => true,
                'metadata' => json_encode($request['metadata'])
            ]);

            if (!$category) {
                return response()->json([
                    'message' => 'Gagal menyimpan data Kategori'
                ], 500);
            }

            return response()->json([
                'message' => 'Kategori berhasil ditambahkan'
            ], 201);
        } catch (Throwable $e) {

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    public function show($id)
    {
        try {

            $category = Category::findOrFail($id);

            return response()->json([
                'message' => 'Category ditemukan',
                'category' => $category
            ]);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'message' => 'Category tidak ditemukan'
            ], 404);

        } catch (Throwable $e) {

            return response()->json([
                'message' => 'Terjadi kesalahan dengan server'
            ], 500);
        }
    }

    public function update(CategoryUpdateRequest $request, $id)
    {
        try {

            $category = Category::findOrFail($id);

            $updated = $category->update([
                'name' => $request->has('name') ? $request['name'] : $category->name,
                'is_active' => $request->has('is_active') ? $request['is_active'] : $category->is_active,
                'metadata' => $request->has('metadata') ? json_encode($request['metadata']) : $category->metadata
            ]);

            if (!$updated) {
                return response()->json([
                    'message' => 'Gagal mengupdate data Kategori'
                ], 500);
            }

            return response()->json([
                'message' => 'Kategori berhasil diupdate!'
            ], 200);
        } catch (ModelNotFoundException $e) {

            return response()->json([
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {

            $category = Category::findOrFail($id);
            $deleteCategory = $category->delete();

            if (!$deleteCategory) {
                return response()->json([
                    'message' => 'Gagal menghapus data Kategori'
                ], 500);
            }

            return response()->json([
                'message' => 'Kategori berhasil dihapus!',
            ], 200);
        } catch (ModelNotFoundException $e) {

            return response()->json([
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        } catch (Throwable $e) {

            return response()->json([
                'message' => "Terjadi kesalahan pada server"
            ], 500);
        }
    }
}
