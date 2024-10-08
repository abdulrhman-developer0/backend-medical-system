<?php

namespace Modules\Report\Http\Controllers;

use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Medical\Entities\Doctor;
use Modules\Medical\Entities\Patient;
use Modules\Medical\Entities\Service;
use Modules\Report\Transformers\DoctorReportCollection;
use Modules\Report\Transformers\DoctorReportResource;
use Modules\Report\Transformers\PatientReportResource;
use Modules\Report\Transformers\ServiceReportResource;

class ReportController extends Controller
{
    use ApiResponses;

    public function doctors(Request $request)
    {

        $query = Doctor::query()
            ->with('clinic')
            ->with('appointments');


        if ($request->doctorId) {
            $ids = explode(',', trim($request->doctorId, ','));
            $query->whereIn('id', $ids);
        }

        $doctors = $query->get();



        return $this->okResponse(
            message: "API success call",
            data: [
                'doctors_count' => $doctors->count(),
                'data' => DoctorReportResource::collection($doctors)
            ]
        );
    }

    public function patients(Request $request)
    {

        $query = Patient::query()
            ->with('appointments');


        if ($request->patientId) {
            $ids = explode(',', trim($request->patientId, ','));
            $query->whereIn('id', $ids);
        }

        $patients = $query->get();



        return $this->okResponse(
            message: "API success call",
            data: [
                'patients_count' => $patients->count(),
                'data' => PatientReportResource::collection($patients)
            ]
        );
    }

    public function services(Request $request)
    {

        $query = Service::query()
            ->with('invoiceItems', function ($q) use ($request) {
                if ($request->date) {
                    $q->whereDate('created_at', $request->date);
                }
            });


        if ($request->serviceId) {
            $ids = explode(',', trim($request->serviceId, ','));
            $query->whereIn('id', $ids);
        }

        $services = $query->get();



        return $this->okResponse(
            message: "API success call",
            data: [
                'services_count' => $services->count(),
                'data' => ServiceReportResource::collection($services)
            ]
        );
    }
}
