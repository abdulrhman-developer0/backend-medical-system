<?php

namespace Modules\Medical\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Medical\Entities\Doctor;

class UpdateDoctorRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'clinicId' => 'nullable|integer|exists:clinics,id',
            'specialtyId' => 'nullable|integer|exists:specialties,id',
            'email' => 'nullable|email|max:255',
            'password' => 'nullable|string|min:8',
            'status'   => "nullable|string|in:$statuses",


            'availableTimes' => 'nullable|array',
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
