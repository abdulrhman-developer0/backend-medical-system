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
        // get updated settings
        $updatedSettings = $request->validated();

        // merge setings and intracts with database.
        foreach ($updatedSettings as $key => $vlaue) {
            // get setting by key
            $setting = Setting::find($key);
            if (! $setting) continue;

            $setting->value = array_merge(
                $setting->value  ?? [],
                $vlaue ?? []
            );

            $setting->save();
        }

        return $this->okResponse(
            message: 'Settings updated successfully'
        );
    }
}
