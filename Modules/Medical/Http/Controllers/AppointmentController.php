<?php

namespace Modules\Medical\Http\Controllers;

use App\Facades\TDOFacade;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Medical\Entities\Appointment;
use Modules\Medical\Http\Requests\StoreAppointmentRequest;
use Modules\Medical\Http\Requests\UpdateAppointmentRequest;
use Modules\Medical\Http\Requests\UpdateAppointmentStatusRequest;
use Modules\Medical\Transformers\AppointmentResource;

class AppointmentController extends Controller
{
    use ApiResponses;

    public function __construct()
    {
        $this->middleware(['type:admin'])
            ->only([
                'update',
                'destroy'
            ]);

        $this->middleware(['type:reception'])
            ->only([
                'store',
                'update',
            ]);
    }

    /**
     * Display a list of clinics.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Appointment::latest();

        if ($request->statuses) {
            // "pending,current,left,"
            $statuses = explode(',', trim($request->statuses, ','));
            $query->whereIn('status', $statuses);
        }

        $user = $request->user();

        if (in_array($user->type, ['reception', 'admin'])) {
            $appointments = $query->get();
        } elseif ($user->type == 'doctor') {
            $appointments = $query->whereDoctorId($user->doctor->id)
                ->get();
        } else {
            $appointments = new Collection();
        }

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

    public function updateStatus(UpdateAppointmentStatusRequest $request, $id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return $this->badResponse(
                message: "Appointment not found"
            );
        }

        $status = $request->status;

        $appointment->status = $request->status;

        if ($request->status == 'canceled') {
            $appointment->canceled_log = $request->canceledLog;
        }

        if ($request->status == 'paid') {
            $appointment->type_of_payment = $request->typeOfPayment;
        }

        $appointment->save();



        return $this->okResponse(
            message: "API call successful",
            data: [
                'data' => AppointmentResource::make($appointment)
            ]
        );
    }

    public function discount(Request $request, $id)
    {
        $request->validate([
            'discount'  => 'required|numeric|min:1|max:100',
        ]);

        $appointment = Appointment::find($id);

        if (!$appointment) {
            return $this->badResponse(
                message: "Appointment not found"
            );
        }

        if ($appointment->discount == 0) {
            $appointment->discount = $request->discount;
            $appointment->save();
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
    public function update(UpdateAppointmentStatusRequest $request, $id)
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
