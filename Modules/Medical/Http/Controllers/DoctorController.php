<?php

namespace Modules\Medical\Http\Controllers;

use App\Facades\TDOFacade;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Medical\Entities\Doctor;
use Modules\Medical\Http\Requests\StoreDoctorRequest;
use Modules\Medical\Http\Requests\UpdateDoctorRequest;
use Modules\Medical\Transformers\DoctorResource;
use Modules\User\Entities\User;

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
                'data' => DoctorResource::collection($doctors)
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
            ->except([
                'email',
                'password',
                'available_times'
            ])
            ->toArray();

        $userData = $request->only(['email', 'password']);
        $creationData['password'] = Hash::make($userData['password']);
        $userData['type'] = 'doctor';
        $user = User::create($userData);


        $creationData['user_id'] = $user->id;
        $doctor = Doctor::create($creationData);

        $doctor->availableTimes()
            ->create($tdo->availableTimes);

        return $this->okResponse(
            message: "Doctor created successfully",
            data: [
                'data' => DoctorResource::make($doctor)
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
                'data' => DoctorResource::make($doctor)
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
        $updateData = collect($tdo->asSnake())
            ->except([
                'email',
                'password',
                'available_times'
            ])
            ->toArray();

        $doctor->update($updateData);

        $userData = $request->only(['email', 'password']);
        if ( isset($userData['password']) ) $creationData['password'] = Hash::make($userData['password']);
        $doctor->user->update($userData);

        $doctor->availableTimes()
            ->update($tdo->availableTimes);

        return $this->okResponse(
            message: "Doctor updated successfully",
            data: [
                'data' => DoctorResource::make($doctor)
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
