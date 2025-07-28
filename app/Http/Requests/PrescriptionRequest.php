<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionRequest extends FormRequest
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
            'checkup_id' => 'required|exists:checkups,id',

            'detail.medicine'   => 'nullable|array|min:1',
            'detail.medicine.*' => 'nullable|string',
            'detail.qty'           => 'nullable|array|min:1',
            'detail.qty.*'         => 'nullable|numeric',
            'detail.price'           => 'nullable|array|min:1',
            'detail.price.*'         => 'nullable|numeric',
        ];
    }
}
