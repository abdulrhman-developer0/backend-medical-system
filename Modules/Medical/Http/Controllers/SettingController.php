<?php

namespace Modules\Medical\Http\Controllers;

use App\Traits\ApiResponses;
use Illuminate\Routing\Controller;
use Modules\Medical\Entities\Setting;
use Illuminate\Http\Request;
use Modules\Medical\Http\Requests\SettingRequest;

class SettingController extends Controller
{
    use ApiResponses;

    public function index()
    {
        $settings = Setting::get();

        return $this->okResponse(
            message: 'API success call',
            data: [
                'data' => $settings->reduce(function ($settings, $model) {
                    $settings[$model->key] =  $model->value;
                    return $settings;
                }, [])
            ]
        );
    }

    public function update(SettingRequest $request)
    {
        $settings = $request->validated();

        foreach ($settings as $key => $value) {
            Setting::find($key)?->update(['value' => $value]);
        }

        return $this->okResponse(
            message: 'Settings updated successfully'
        );
    }
}
