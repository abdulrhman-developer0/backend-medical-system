<?php

namespace Modules\Medical\Http\Controllers;

use App\Facades\TDOFacade;
use App\Traits\ApiResponses;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Medical\Entities\Appointment;
use Modules\Medical\Http\Requests\StoreAppointmentRequest;
use Modules\Medical\Http\Requests\UpdateAppointmentRequest;
use Modules\Medical\Transformers\AppointmentResource;

class AppointmentController extends Controller
{
    use ApiResponses;

    /**
     * Display a list of clinics.
     *
     * @return Response
     */
    public function index()
    {
        $appointments = Appointment::all();

        return $this->okResponse(
            message: "API call successful",
            data: [
                'data' => AppointmentResource::collection($appointments)
            ]
        );
    }

    /**
     * Store a newly created clinic in storage.
     *
     * @param StoreAppointmentRequest $request
     * @return Response
     */
    public function store(StoreAppointmentRequest $request)
    {
        $tdo = TDOFacade::make($request);

        $creationData = collect($tdo->asSnake())
            ->except([])
            ->toArray();

        $appointment = Appointment::create($creationData);

        return $this->okResponse(
            message: "Appointment created successfully",
            data: [
                'data' => AppointmentResource::make($appointment)
            ]
        );
    }

    /**
     * Display the specified clinic.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return $this->badResponse(
                message: "Appointment not found"
            );
        }

        return $this->okResponse(
            message: "API call successful",
            data: [
                'data' => AppointmentResource::make($appointment)
            ]
        );
    }

    /**
     * Update the specified clinic in storage.
     *
     * @param UpdateAppointmentRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateAppointmentRequest $request, $id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return $this->badResponse(
                message: "Appointment not found"
            );
        }

        $tdo = TDOFacade::make($request);
        $updateData = collect($tdo->asSnake())->except([])->toArray();

        $appointment->update($updateData);

        return $this->okResponse(
            message: "Appointment updated successfully",
            data: [
                'data' => AppointmentResource::make($appointment)
            ]
        );
    }

    /**
     * Remove the specified clinic from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return $this->badResponse(
                message: "Appointment not found"
            );
        }

        $appointment->delete();

        return $this->okResponse(
            message: "Appointment deleted successfully"
        );
    }
}
