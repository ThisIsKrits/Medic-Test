<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckupRequest extends FormRequest
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
            'no'        => 'required|string',
            'tgl'       => 'required|date',
            'patient_id' => 'required|exists:patients,id',
            'note'      => 'nullable|string',

            'detail.type_vital_id'   => 'nullable|array|min:1',
            'detail.type_vital_id.*' => 'nullable|exists:type_vitals,id',
            'detail.value'           => 'nullable|array|min:1',
            'detail.value.*'         => 'nullable|string|max:255',

            'document'     => 'nullable|array',
            'document.*'   => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }
}
