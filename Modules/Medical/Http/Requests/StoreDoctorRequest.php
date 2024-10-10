<?php

namespace Modules\Medical\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Medical\Entities\Doctor;

class StoreDoctorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $statuses = implode(',', Doctor::$statuses);

        return [
            'name' => 'required|string|max:255',
            'clinicId' => 'required|integer|exists:clinics,id',
            'specialtyId' => 'required|integer|exists:specialties,id',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'status'   => "required|string|in:$statuses",

            'availableTimes' => 'required|array',
            'availableTimes.mon' => 'nullable|array',
            'availableTimes.tue' => 'nullable|array',
            'availableTimes.wed' => 'nullable|array',
            'availableTimes.thu' => 'nullable|array',
            'availableTimes.fri' => 'nullable|array',
            'availableTimes.sat' => 'nullable|array',
            'availableTimes.sun' => 'nullable|array',
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
