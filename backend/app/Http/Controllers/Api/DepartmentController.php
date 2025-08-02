<?php

namespace App\Http\Controllers\Api;

use Throwable;

use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DepartmentController extends Controller
{
    public function index()
    {
 
        try {

            $department = Department::get();

            return response()->json([
                'department' => $department
            ]);

        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);

        }
    }

    public function store(DepartmentStoreRequest $request)
    {
        
        try {

            $department = Department::create([
                'name' => $request['name'],
                'is_active' => true,
                'metadata' => json_encode($request['metadata'])
            ]);

            if (!$department) {
                return response()->json([
                    'message' => 'Gagal menyimpan data Departemen'
                ], 500);
            }

            return response()->json([
                'message' => 'Departemen berhasil ditambahkan'
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

            $department = Department::findOrFail($id);

            return response()->json([
                'message' => 'Department ditemukan',
                'department' => $department
            ]);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'message' => 'Department tidak ditemukan'
            ], 404);

        } catch (Throwable $e) {

            return response()->json([
                'message' => 'Terjadi kesalahan dengan server'
            ], 500);
        }
    }

    public function update(DepartmentUpdateRequest $request, $id)
    {
        try {

            $department = Department::findOrFail($id);

            $updated = $department->update([
                'name' => $request->has('name') ? $request['name'] : $department->name,
                'is_active' => $request->has('is_active') ? $request['is_active'] : $department->is_active,
                'metadata' => $request->has('metadata') ? json_encode($request['metadata']) : $department->metadata
            ]);

            if (!$updated) {
                return response()->json([
                    'message' => 'Gagal mengupdate data Departemen'
                ], 500);
            }

            return response()->json([
                'message' => 'Departemen berhasil diupdate!'
            ], 200);
        } catch (ModelNotFoundException $e) {

            return response()->json([
                'message' => 'Departemen tidak ditemukan'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {

            $department = Department::findOrFail($id);
            $deleteDepartment = $department->delete();

            if (!$deleteDepartment) {
                return response()->json([
                    'message' => 'Gagal menghapus data Departemen'
                ], 500);
            }

            return response()->json([
                'message' => 'Departemen berhasil dihapus!',
            ], 200);
        } catch (ModelNotFoundException $e) {

            return response()->json([
                'message' => 'Departemen tidak ditemukan'
            ], 404);
        } catch (Throwable $e) {

            return response()->json([
                'message' => "Terjadi kesalahan pada server"
            ], 500);
        }
    }
}
