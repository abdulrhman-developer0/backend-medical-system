<?php

namespace Modules\Medical\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiagnosisRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'appointmentId' => 'required|exists:appointments,id',
            'diagnosis' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'diagnosisDate' => 'required|date',
            'services'      => 'required|array',
            'services.*'    => 'required|integer|exists:services,id',
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
