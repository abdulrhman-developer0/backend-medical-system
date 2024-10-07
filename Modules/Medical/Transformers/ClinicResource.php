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
        $doctor = $this->withCount('doctors')
            ->get();
        return [
            'id'         => $doctor->id,
            'name'      => $doctor->name,
            'doctors'   => $doctor->withCount('doctors')
        ];
    }
}
