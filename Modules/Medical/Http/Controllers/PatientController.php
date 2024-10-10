<?php

namespace Modules\Medical\Http\Controllers;

use App\Facades\TDOFacade;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Medical\Entities\Patient;
use Modules\Medical\Http\Requests\StorePatientRequest;
use Modules\Medical\Http\Requests\updatePatientRequest;
use Modules\Medical\Transformers\PatientResource;

class PatientController extends Controller
{
    use ApiResponses;

    public function __construct()
    {
        $this->middleware(['type:reception,doctor,admin'])
            ->only([
                'store',
                'update',
            ]);

            $this->middleware(['type:admin'])
            ->only([
                'destroy'
            ]);
    }

    /**
     * Display a list of clinics.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Patient::query()
            ->latest();

        if ($request->search) {
            $search = $request->search;

            $query
                ->where('name', 'like', "%$search%")
                ->orWhere('mobile', 'like', "%$search%")
                ->orWhere('national_id', 'like', "%$search%")
                ->orWhere('id', $search);
        }

        $patients = $query->get();

        return $this->okResponse(
            message: "API call successful",
            data: [
                'data' => PatientResource::collection($patients)
            ]
        );
    }

    /**
     * Store a newly created clinic in storage.
     *
     * @param StorePatientRequest $request
     * @return Response
     */
    public function store(StorePatientRequest $request)
    {
        $tdo = TDOFacade::make($request);

        $creationData = collect($tdo->asSnake())
            ->except([])
            ->toArray();

        $patient = Patient::create($creationData);

        return $this->okResponse(
            message: "Patient created successfully",
            data: [
                'data' => PatientResource::make($patient)
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
        $patient = Patient::find($id);

        if (!$patient) {
            return $this->badResponse(
                message: "Patient not found"
            );
        }

        return $this->okResponse(
            message: "API call successful",
            data: [
                'data' => PatientResource::make($patient)
            ]
        );
    }

    /**
     * Update the specified clinic in storage.
     *
     * @param UpdatePatientRequest $request
     * @param int $id
     * @return Response
     */
    public function update(updatePatientRequest $request, $id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return $this->badResponse(
                message: "Patient not found"
            );
        }

        $tdo = TDOFacade::make($request);
        $updateData = collect($tdo->asSnake())->except([])->toArray();

        $patient->update($updateData);

        return $this->okResponse(
            message: "Patient updated successfully",
            data: [
                'data' => PatientResource::make($patient)
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
        $patient = Patient::find($id);

        if (!$patient) {
            return $this->badResponse(
                message: "Patient not found"
            );
        }

        $patient->delete();

        return $this->okResponse(
            message: "Patient deleted successfully"
        );
    }
}
