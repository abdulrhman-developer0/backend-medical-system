<?php

namespace Modules\Medical\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updatePatientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:15',
            'nationalId' => 'nullable|min:10|max:20',
            'address' => 'nullable|string|max:255',
            'age' => 'nullable|integer',
            'dateOfBirth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
