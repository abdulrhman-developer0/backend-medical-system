<?php

namespace Modules\Medical\Http\Controllers;

use App\Facades\TDOFacade;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Medical\Entities\Doctor;
use Modules\Medical\Http\Requests\StoreDoctorRequest;
use Modules\Medical\Http\Requests\UpdateDoctorRequest;

class DoctorController extends Controller
{
    use ApiResponses;

    /**
     * Display a list of doctors.
     *
     * @return Response
     */
    public function index()
    {
        $doctors = Doctor::all();

        return $this->okResponse(
            message: "API call successful",
            data: [
                'data' => $doctors
            ]
        );
    }

    /**
     * Store a newly created doctor in storage.
     *
     * @param StoreDoctorRequest $request
     * @return Response
     */
    public function store(StoreDoctorRequest $request)
    {
        $tdo = TDOFacade::make($request);

        $creationData = collect($tdo->asSnake())
            ->except([])
            ->toArray();

        $doctor = Doctor::create($creationData);

        return $this->okResponse(
            message: "Doctor created successfully",
            data: [
                'data' => $doctor
            ]
        );
    }

    /**
     * Display the specified doctor.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return $this->badResponse(
                message: "Doctor not found"
            );
        }

        return $this->okResponse(
            message: "API call successful",
            data: [
                'data' => $doctor
            ]
        );
    }

    /**
     * Update the specified doctor in storage.
     *
     * @param UpdateDoctorRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateDoctorRequest $request, $id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return $this->badResponse(
                message: "Doctor not found"
            );
        }

        $tdo = TDOFacade::make($request);
        $updateData = collect($tdo->asSnake())->except([])->toArray();

        $doctor->update($updateData);

        return $this->okResponse(
            message: "Doctor updated successfully",
            data: [
                'data' => $doctor
            ]
        );
    }

    /**
     * Remove the specified doctor from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return $this->badResponse(
                message: "Doctor not found"
            );
        }

        $doctor->delete();

        return $this->okResponse(
            message: "Doctor deleted successfully"
        );
    }
}
