<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentUpdateRequest extends FormRequest
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
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|min:10|max:500',
            'metadata' => 'sometimes',
            'file_path' => 'sometimes|file|mimes:pdf|min:100|max:500',
            'is_active' => 'sometimes|boolean',
            'category_id' => 'sometimes|uuid',
            'department_id' => 'sometimes|uuid',
            'uploaded_by' => 'sometimes|uuid',
        ];
    }
}
