<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10|max:500',
            'metadata' => 'required',
            'file_path' => 'required|file|mimes:pdf|min:100|max:500',
            'is_active' => 'required|boolean',
            'category_id' => 'required|uuid',
            'department_id' => 'required|uuid',
            'uploaded_by' => 'required|uuid',
        ];
    }
}
