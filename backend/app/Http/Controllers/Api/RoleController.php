<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleStoreRequest;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class RoleController extends Controller
{
    public function index()
    {

        try {

            $role = Role::get();

            return response()->json([
                'role' => $role
            ]);

        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);

        }
    }

    public function store(RoleStoreRequest $request)
    {

        try {

            $role = Role::create([
                'name' => $request['name']
            ]);

            if (!$role) {
                return response()->json([
                    'message' => 'Gagal menyimpan data Role'
                ], 500);
            }

            return response()->json([
                'message' => 'Role berhasil ditambahkan'
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

            $role = Role::findOrFail($id);

            return response()->json([
                'message' => 'Role ditemukan',
                'role' => $role
            ]);
        } catch (ModelNotFoundException $e) {

            return response()->json([
                'message' => 'Role tidak ditemukan'
            ], 404);
        } catch (Throwable $e) {

            return response()->json([
                'message' => 'Terjadi kesalahan dengan server'
            ], 500);
        }
    }

    public function update(RoleStoreRequest $request, $id)
    {
        try {

            $role = Role::findOrFail($id);

            $updated = $role->update([
                'name' => $request['name']
            ]);

            if (!$updated) {
                return response()->json([
                    'message' => 'Gagal mengupdate data Role'
                ], 500);
            }

            return response()->json([
                'message' => 'Role berhasil diupdate!'
            ], 200);
        } catch (ModelNotFoundException $e) {

            return response()->json([
                'message' => 'Role tidak ditemukan'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {

            $role = Role::findOrFail($id);
            $deleteRole = $role->delete();

            if (!$deleteRole) {
                return response()->json([
                    'message' => 'Gagal menghapus data Role'
                ], 500);
            }

            return response()->json([
                'message' => 'Role berhasil dihapus!',
            ], 200);
        } catch (ModelNotFoundException $e) {

            return response()->json([
                'message' => 'Role tidak ditemukan'
            ], 404);
        } catch (Throwable $e) {

            return response()->json([
                'message' => "Terjadi kesalahan pada server"
            ], 500);
        }
    }
}
