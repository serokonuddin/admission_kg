<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollegeStudentStoreRequest extends FormRequest
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
            'photo' => 'nullable|file|mimes:jpg,jpeg|max:1024',
            'testimonial' => 'nullable|file|mimes:pdf,jpg,jpeg|max:1024',
            'academic_transcript' => 'nullable|file|mimes:pdf,jpg,jpeg|max:1024',
            'birth_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg|max:1024',
            'admit_card' => 'nullable|file|mimes:jpg,jpeg,pdf|max:1024',
            'staff_certification' => 'nullable|file|mimes:jpg,jpeg,pdf|max:1024',
            'arm_certification' => 'nullable|file|mimes:jpg,jpeg,pdf|max:1024',
            'father_nid' => 'nullable|file|mimes:jpg,jpeg,pdf|max:1024',
            'mother_nid' => 'nullable|file|mimes:jpg,jpeg,pdf|max:1024',
            'religion' => 'required',
            'nationality' => 'required',
            // 'birthdate' => 'required',
            'mobile' => 'required|numeric|min:11',
            // 'local_guardian_name' => 'required',
            // 'local_guardian_mobile' => 'required',
            'gender' => 'required',
            // 'session_id' => 'required',
            // 'version_id' => 'required',
            // 'class_code' => 'required',
            'mother_nid_number' => 'nullable|numeric|min:11',
            'father_nid_number' => 'nullable|numeric|min:11',
            'sms_notification' => 'required|numeric|min:11',

        ];
    }
}
