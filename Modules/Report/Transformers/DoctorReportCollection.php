<?php

namespace Modules\Report\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DoctorReportCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
