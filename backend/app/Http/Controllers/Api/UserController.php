<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {

        try {

            $user = User::get();

            return response()->json([
                'user' => $user
            ], 200);

        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    public function show($id)
    {
        try {

            $user = User::findOrFail($id);

            if (!$user) {
                return response()->json([
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'message' => 'User ditemukan!',
                'user' => $user
            ], 200);
        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    public function store(UserStoreRequest $request)
    {
        try {

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'role_id' => '2'
            ]);

            if (!$user) {
                return response()->json([
                    'message' => 'Gagal menambahkan data User'
                ], 500);
            }

            return response()->json([
                'message' => 'Berhasil menambahkan User',
                'user' => $user
            ], 201);
        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {

        try {

            $user = User::findOrFail($id);

            if (!$user) {
                return response()->json([
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            $updateUser = $user->update([
                'name' => $request->has('name') ? $request['name'] : $user->name,
                'email' => $request->has('email') ? $request['email'] : $user->email,
                'password' => $request->has('password') ? bcrypt($request['password']) : $user->password,
                'role_id' => $request->has('role_id') ? $request['role_id'] : $user->role_id
            ]);

            if (!$updateUser) {
                return response()->json([
                    'message' => 'Gagal mengubah User'
                ], 500);
            }

            return response()->json([
                'message' => 'Berhasil mengubah User!',
            ], 200);
        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {

            $user = User::findOrFail($id);

            if (!$user) {
                return response()->json([
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            $deleteUser = $user->delete();

            if (!$deleteUser) {
                return response()->json([
                    'message' => 'Gagal menghapus User'
                ], 500);
            }

            return response()->json([
                'message' => 'Berhasil menghapus User'
            ], 200);
        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }
}
