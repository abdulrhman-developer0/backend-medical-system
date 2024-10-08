<?php

namespace Modules\Medical\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'nationalId' => 'required|min:14|max:20',
            'address' => 'nullable|string|max:255',
            'age' => 'nullable|integer',
            'dateOfBirth' => 'nullable|date',
            'gender' => 'required|in:male,female',
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
