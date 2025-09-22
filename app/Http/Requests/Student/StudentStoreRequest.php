<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
            'photo' => 'mimes:jpg,jpeg|max:6000', // size in KB
			'academic_transcript' => 'mimes:jpg,jpeg,pdf|max:200', // size in KB
			'admit_card' => 'mimes:jpg,jpeg,pdf|max:200', // size in KB
			'testimonial' => 'nullable|mimes:jpg,jpeg,pdf|max:200', // size in KB
			'birth_certificate' => 'nullable|mimes:jpg,jpeg,pdf|max:200', // size in KB
			'father_nid' => 'nullable|mimes:jpg,jpeg,pdf|max:200', // size in KB
			'mother_nid' => 'nullable|mimes:jpg,jpeg,pdf|max:200', // size in KB
			'arm_certification' => 'nullable|mimes:jpg,jpeg,pdf|max:200', // size in KB
			'staff_certification' => 'nullable|mimes:jpg,jpeg,pdf|max:200', // size in KB
			 'studentXl' => 'nullable|file|mimes:xlsx,xls,csv|max:200',

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
{
    return [
        // photo
        'photo.required' => 'The photo is required.',
        'photo.mimes' => 'The photo must be a file of type: jpg, jpeg.',
        'photo.max' => 'The photo size must not exceed 6000KB.',

        // academic_transcript
        'academic_transcript.required' => 'The academic transcript is required.',
        'academic_transcript.mimes' => 'The academic transcript must be a file of type: jpg, jpeg, or pdf.',
        'academic_transcript.max' => 'The academic transcript size must not exceed 200KB.',

        // admit_card
        'admit_card.required' => 'The admit card is required.',
        'admit_card.mimes' => 'The admit card must be a file of type: jpg, jpeg, or pdf.',
        'admit_card.max' => 'The admit card size must not exceed 200KB.',

        // testimonial
        'testimonial.mimes' => 'The testimonial must be a file of type: jpg, jpeg, or pdf.',
        'testimonial.max' => 'The testimonial size must not exceed 200KB.',

        // birth_certificate
        'birth_certificate.mimes' => 'The birth certificate must be a file of type: jpg, jpeg, or pdf.',
        'birth_certificate.max' => 'The birth certificate size must not exceed 200KB.',

        // father_nid
        'father_nid.mimes' => 'The father NID must be a file of type: jpg, jpeg, or pdf.',
        'father_nid.max' => 'The father NID size must not exceed 200KB.',

        // mother_nid
        'mother_nid.mimes' => 'The mother NID must be a file of type: jpg, jpeg, or pdf.',
        'mother_nid.max' => 'The mother NID size must not exceed 200KB.',

        // arm_certification
        'arm_certification.mimes' => 'The ARM certification must be a file of type: jpg, jpeg, or pdf.',
        'arm_certification.max' => 'The ARM certification size must not exceed 200KB.',

        // staff_certification
        'staff_certification.mimes' => 'The staff certification must be a file of type: jpg, jpeg, or pdf.',
        'staff_certification.max' => 'The staff certification size must not exceed 200KB.',

        // studentXl
        'studentXl.mimes' => 'The student Excel file must be of type: xlsx, xls, or csv.',
        'studentXl.max' => 'The student Excel file size must not exceed 200KB.',
    ];
}

}
