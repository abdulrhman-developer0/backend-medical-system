<?php

namespace Modules\Medical\Http\Controllers;

use App\Facades\TDOFacade;
use App\Traits\ApiResponses;
use Illuminate\Routing\Controller;
use Modules\Medical\Entities\Specialty;
use Modules\Medical\Http\Requests\StoreSpecialtyRequest;
use Modules\Medical\Http\Requests\UpdateSpecialtyRequest;
use Modules\Medical\Transformers\SpecialtyResource;

class SpecialtyController extends Controller
{
    use ApiResponses;

    public function __construct()
    {
        $this->middleware(['type:admin'])
            ->only([
                'store',
                'update',
                'destroy'
            ]);
    }

    /**
     * Display a list of clinics.
     *
     * @return Response
     */
    public function index()
    {
        $specialtys = Specialty::query()
            ->latest()
            ->get();

        return $this->okResponse(
            message: "API call successful",
            data: [
                'data' => SpecialtyResource::collection($specialtys)
            ]
        );
    }

    /**
     * Store a newly created clinic in storage.
     *
     * @param StoreSpecialtyRequest $request
     * @return Response
     */
    public function store(StoreSpecialtyRequest $request)
    {
        $tdo = TDOFacade::make($request);

        $creationData = collect($tdo->asSnake())
            ->except([])
            ->toArray();

        $specialty = Specialty::create($creationData);

        return $this->okResponse(
            message: "Specialty created successfully",
            data: [
                'data' => SpecialtyResource::make($specialty)
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
        $specialty = Specialty::find($id);

        if (!$specialty) {
            return $this->badResponse(
                message: "Specialty not found"
            );
        }

        return $this->okResponse(
            message: "API call successful",
            data: [
                'data' => SpecialtyResource::make($specialty)
            ]
        );
    }

    /**
     * Update the specified clinic in storage.
     *
     * @param UpdateSpecialtyRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateSpecialtyRequest $request, $id)
    {
        $specialty = Specialty::find($id);

        if (!$specialty) {
            return $this->badResponse(
                message: "Specialty not found"
            );
        }

        $tdo = TDOFacade::make($request);
        $updateData = collect($tdo->asSnake())->except([])->toArray();

        $specialty->update($updateData);

        return $this->okResponse(
            message: "Specialty updated successfully",
            data: [
                'data' => SpecialtyResource::make($specialty)
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
        $specialty = Specialty::find($id);

        if (!$specialty) {
            return $this->badResponse(
                message: "Specialty not found"
            );
        }

        $specialty->delete();

        return $this->okResponse(
            message: "Specialty deleted successfully"
        );
    }
}
