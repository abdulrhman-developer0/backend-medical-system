<?php

namespace Modules\Medical\Http\Controllers;

use App\Facades\TDOFacade;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Medical\Entities\Clinic;
use Modules\Medical\Http\Requests\StoreClinicRequest;
use Modules\Medical\Http\Requests\UpdateClinicRequest;

class ClinicController extends Controller
{
    use ApiResponses;

    /**
     * Display a list of clinics.
     *
     * @return Response
     */
    public function index()
    {
        $clinics = Clinic::all();

        return $this->okResponse(
            message: "API call successful",
            data: [
                'data' => $clinics
            ]
        );
    }

    /**
     * Store a newly created clinic in storage.
     *
     * @param StoreClinicRequest $request
     * @return Response
     */
    public function store(StoreClinicRequest $request)
    {
        $tdo = TDOFacade::make($request);

        $creationData = collect($tdo->asSnake())
            ->except([])
            ->toArray();

        $clinic = Clinic::create($creationData);

        return $this->okResponse(
            message: "Clinic created successfully",
            data: [
                'data' => $clinic
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
        $clinic = Clinic::find($id);

        if (!$clinic) {
            return $this->badResponse(
                message: "Clinic not found"
            );
        }

        return $this->okResponse(
            message: "API call successful",
            data: [
                'data' => $clinic
            ]
        );
    }

    /**
     * Update the specified clinic in storage.
     *
     * @param UpdateClinicRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateClinicRequest $request, $id)
    {
        $clinic = Clinic::find($id);

        if (!$clinic) {
            return $this->badResponse(
                message: "Clinic not found"
            );
        }

        $tdo = TDOFacade::make($request);
        $updateData = collect($tdo->asSnake())->except([])->toArray();

        $clinic->update($updateData);

        return $this->okResponse(
            message: "Clinic updated successfully",
            data: [
                'data' => $clinic
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
        $clinic = Clinic::find($id);

        if (!$clinic) {
            return $this->badResponse(
                message: "Clinic not found"
            );
        }

        $clinic->delete();

        return $this->okResponse(
            message: "Clinic deleted successfully"
        );
    }
}
