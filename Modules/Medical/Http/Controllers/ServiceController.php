<?php

namespace Modules\Medical\Http\Controllers;

use App\Facades\TDOFacade;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Medical\Entities\Service;
use Modules\Medical\Http\Requests\StoreServiceRequest;
use Modules\Medical\Http\Requests\UpdateServiceRequest;
use Modules\Medical\Transformers\ServiceResource;

class ServiceController extends Controller
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
    public function index(Request $request)
    {
        $querty = Service::latest();

        if ( $request->stype ) {
            $querty->where('stype', $request->stype);
        }


        $services = $querty->get();

        return $this->okResponse(
            message: "API call successful",
            data: [
                'data' => ServiceResource::collection($services)
            ]
        );
    }

    /**
     * Store a newly created clinic in storage.
     *
     * @param StoreServiceRequest $request
     * @return Response
     */
    public function store(StoreServiceRequest $request)
    {
        $tdo = TDOFacade::make($request);

        $creationData = collect($tdo->asSnake())
            ->except([])
            ->toArray();

        $service = Service::create($creationData);

        return $this->okResponse(
            message: "Service created successfully",
            data: [
                'data' => ServiceResource::make($service)
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
        $service = Service::find($id);

        if (!$service) {
            return $this->badResponse(
                message: "Service not found"
            );
        }

        return $this->okResponse(
            message: "API call successful",
            data: [
                'data' => ServiceResource::make($service)
            ]
        );
    }

    /**
     * Update the specified clinic in storage.
     *
     * @param UpdateServiceRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateServiceRequest $request, $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return $this->badResponse(
                message: "Service not found"
            );
        }

        $tdo = TDOFacade::make($request);
        $updateData = collect($tdo->asSnake())->except([])->toArray();

        $service->update($updateData);

        return $this->okResponse(
            message: "Service updated successfully",
            data: [
                'data' => ServiceResource::make($service)
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
        $service = Service::find($id);

        if (!$service) {
            return $this->badResponse(
                message: "Service not found"
            );
        }

        $service->delete();

        return $this->okResponse(
            message: "Service deleted successfully"
        );
    }
}
