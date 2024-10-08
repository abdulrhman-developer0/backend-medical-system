<?php

namespace Modules\Medical\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ClinicResource extends JsonResource
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
            'id'         => $this->id,
            'name'      => $this->name,
            'doctors'   => $this->doctors_count
        ];
    }
}
