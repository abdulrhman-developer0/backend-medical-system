<?php

namespace Modules\Report\Http\Controllers;

use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Medical\Entities\Doctor;
use Modules\Report\Transformers\DoctorReportCollection;
use Modules\Report\Transformers\DoctorReportResource;

class ReportController extends Controller
{
    use ApiResponses;

    public function doctors()
    {
        $doctors = Doctor::query()
            ->with('clinic')
            ->with('appointments')
            ->get();

        $doctors->each(function (Doctor $doctor) {});

        return $this->okResponse(
            message: "API success call",
            data: [
                'doctors_count' => $doctors->count(),
                'data' => DoctorReportResource::collection($doctors)
            ]
        );
    }
}
