<?php

namespace App\Http\Requests\AcademyActivity;

use Illuminate\Foundation\Http\FormRequest;

class AcademyActivityStoreRequest extends FormRequest
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
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'file.required' => 'An Excel file is required.',
            'file.mimes' => 'The file must be an Excel file (xlsx, xls, or csv).',
            'file.max' => 'The file must not exceed 2MB.',
        ];
    }
}
