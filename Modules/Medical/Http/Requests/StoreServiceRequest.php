<?php

namespace Modules\Medical\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Medical\Entities\Service;

class StoreServiceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $stypes = implode(',', Service::$types);

        return [
            'name'              => 'required|string|min:1|max:255',
            'description'       => 'required|string|min:1|max:400',
            'price'             => 'required|numeric',
            'stype'             => "required|string|in:$stypes",
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
