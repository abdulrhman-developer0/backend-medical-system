<?php

namespace Modules\Report\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceReportResource extends JsonResource
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
            'service_id'        => $this->id,
            'service_name'      => $this->name,
            'total_collected'   => $this->invoiceItems->sum('amount'),
            'total_sales'       => $this->invoiceItems->count(),
        ];
    }
}
