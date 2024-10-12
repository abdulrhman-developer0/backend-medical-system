<?php

namespace Modules\Medical\Http\Controllers;

use App\Traits\ApiResponses;
use Illuminate\Routing\Controller;
use Modules\Medical\Entities\Appointment;
use Modules\Medical\Entities\Clinic;
use Modules\Medical\Entities\Doctor;
use Modules\Medical\Entities\Patient;
use Modules\Medical\Entities\Service;

class StatController extends Controller
{
    use ApiResponses;

    public function stats()
    {

        $stats['clinics'] = Clinic::count();
        $stats['doctors'] = Doctor::count();
        $stats['services'] = Service::count();
        $stats['patients'] = Patient::count();
        $stats['appointments'] = Appointment::count();
        $stats['analysis'] = Service::where('stype', 'analysis')->count();

        return $this->okResponse(
            message: "API success call",
            data: [
                'data' => $stats
            ]
        );
    }
}
