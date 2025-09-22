<?php

namespace App\Http\Requests\Admission;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionStoreRequest extends FormRequest
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
            'file' => 'nullable|file|mimes:xlsx,xls,csv|max:200',
            'father_nid_' => 'nullable|mimes:jpg,jpeg|max:200',
            'mother_nid' => 'nullable|mimes:jpg,jpeg|max:200',
            'photo' => 'nullable|mimes:jpg,jpeg|max:200',
            'birth_certificate' => 'nullable|mimes:jpg,jpeg|max:200',
            'arm_certification' => 'nullable|mimes:jpg,jpeg|max:200',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'file.mimes' => 'The file must be an Excel file (xlsx, xls, or csv).',
            'file.max' => 'The file must not exceed 200KB.',
            'father_nid_.max' => 'The father NID must not exceed 200 characters.',
            'father_nid_.mimes' => 'The father NID must be a JPG or JPEG file.',
            'mother_nid.mimes' => 'The mother NID must be a JPG or JPEG file.',
            'mother_nid.max' => 'The mother NID must not exceed 200 characters.',
            'photo.mimes' => 'The photo must be a JPG or JPEG file.',
            'photo.max' => 'The photo must not exceed 200KB.',
            'birth_certificate.mimes' => 'The birth certificate must be a JPG or JPEG file.',
            'birth_certificate.max' => 'The birth certificate must not exceed 200KB.',
            'arm_certification.mimes' => 'The arm certification must be a JPG or JPEG file.',
            'arm_certification.max' => 'The arm certification must not exceed 200KB.',
        ];
    }
}
