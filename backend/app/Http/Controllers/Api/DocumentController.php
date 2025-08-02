<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Carbon\Carbon;
use App\Models\Document;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentStoreRequest;
use App\Http\Requests\DocumentUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;


class DocumentController extends Controller
{
    public function index()
    {

        try {

            return Document::latest()->get();
        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    public function show($id)
    {

        try {

            $document = Document::where('id', $id)->first();

            return response()->json([
                'message' => 'Dokumen ditemukan!',
                'document' => $document
            ], 200);
        } catch (ModelNotFoundException $e) {

            return response()->json([
                'message' => "Dokumen tidak ditemukan"
            ], 404);
        } catch (Throwable $e) {

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    public function store(DocumentStoreRequest $request)
    {

        try {


            if ($request->has('file_path')) {
                $file = $request->file('file_path');
                $file_name = md5($file->getClientOriginalName() . Carbon::now()) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('documents', $file_name);
            }


            $document = Document::create([
                'title' => $request['title'],
                'description' => $request['description'],
                'file_path' => $path,
                'category_id' => $request['category_id'],
                'department_id' => $request['department_id'],
                'uploaded_by' => $request['uploaded_by'],
                'is_active' => true,
                'metadata' => json_encode($request['metadata'])
            ]);

            return response()->json([
                'message' => 'Dokumen telah berhasil ditambahkan',
                'document' => $document
            ], 201);
        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    public function update(DocumentUpdateRequest $request, $id)
    {

        try {


            $document = Document::findOrFail($id);

            if (!$document) {
                return response()->json([
                    'message' => 'Dokumen tidak ditemukan'
                ]);
            }

            $documentRequest = [
                'title' => $request->has('title') ? $request['title'] : $document->title,
                'description' => $request->has('description') ? $request['description'] : $document->description,
                'category_id' => $request->has('category_id') ? $request['category_id'] : $document->category_id,
                'department_id' => $request->has('department_id') ? $request['department_id'] : $document->department_id,
                'uploaded_by' => $request->has('uploaded_by') ? $request['uploaded_by'] : $document->uploaded_by,
                'is_active' => $request->has('is_active') ? filter_var($request['is_active'], FILTER_VALIDATE_BOOLEAN) : $document->is_active,
                'metadata' => $request->has('metadata') ? json_encode($request['metadata']) : $document->metadata
            ];

            if ($request->hasFile('file_path')) {
                $file = $request->file('file_path');
                $file_name = md5($file->getClientOriginalName() . Carbon::now()) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('documents', $file_name);

                if($document->file_path && Storage::exists($document->file_path)){
                    Storage::delete($document->file_path);
                }

                $documentRequest['file_path'] = $path;
            }

            $updateDocument = $document->update($documentRequest);

            if (!$updateDocument) {

                return response()->json([
                    'message' => 'Gagal mengubah Dokumen'
                ], 500);
            }

            return response()->json([
                'message' => 'Berhasil mengubah Dokumen!'
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
            
            $document = Document::findOrFail($id);

            if(!$document){
                return response()->json([
                    'message' => 'Dokumen tidak ditemukan'
                ], 404);
            }

            Storage::delete($document->file_path);

            $deleteDocument = $document->delete();



            if(!$deleteDocument) {
                return response()->json([
                    'message' => 'Gagal menghapus Dokumen'
                ], 500);
            }

            return response()->json([
                'message' => 'Dokumen berhasil dihapus'
            ], 200);

        } catch (\Throwable $th) {
            
            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ]);

        }
    }
}
