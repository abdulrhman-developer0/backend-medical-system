<?php

namespace Modules\Medical\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'total'         => $this->total_amount,
            'services'      => $this->invoiceItems-map(function($service) {
                return $service->only(['service_name', 'amount']);
            })
        ];
    }
}
