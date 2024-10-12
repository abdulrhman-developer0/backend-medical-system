<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'type'          => $this->tpe,
            'name'          => $this->name,
            'email'         => $this->email,
            'account_info'  => $this->transformAccountInfo(),
            'created_at'    => $this->created_at->format('Y/m/d'),
            'updated_at'    => $this->updated_at->format('Y/m/d'),
        ];
    }

    private function transformAccountInfo(): object
    {
        $accountInfo = new \stdClass;

        if ( $this->type == 'doctor' ) {
            $accountInfo->clinicId          = $this->doctor->clinic->id;
            $accountInfo->clinicName        = $this->doctor->clinic->name;
            $accountInfo->specialityName    = $this->doctor->speciality->name;
            $accountInfo->examinationCost    = $this->doctor->speciality->examination_cost;
            $accountInfo->availableTimes    = $this->doctor->doctor->available_times;
        }


        return $accountInfo;
    }
}
