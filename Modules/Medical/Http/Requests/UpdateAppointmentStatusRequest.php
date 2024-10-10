<?php

namespace Modules\Medical\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Medical\Entities\Appointment;

class UpdateAppointmentStatusRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $statusList = implode(',', Appointment::$statuses);

        $rules = [
            'status'        => "required|string|in:$statusList",
        ];

        if ($this->satus == 'canceled') {
            $rules['canceledLog']   = 'required|string';
        }

        if ($this->status == 'paid') {
            $paymentTypes = implode(',', Appointment::$paymentTypes);
            $rules['typeOfPayment'] = "required|string|in:$paymentTypes";
        }

        return $rules;
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
