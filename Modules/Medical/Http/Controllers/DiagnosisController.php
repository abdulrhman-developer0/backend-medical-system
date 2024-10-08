<?php

namespace Modules\Medical\Http\Controllers;

use App\Facades\TDOFacade;
use App\Traits\ApiResponses;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Medical\Entities\Diagnosis;
use Modules\Medical\Entities\Service;
use Modules\Medical\Http\Requests\StoreDiagnosisRequest;
use Modules\Medical\Http\Requests\UpdateDiagnosisRequest;
use Modules\Medical\Transformers\DiagnosisResource;

class DiagnosisController extends Controller
{
    use ApiResponses;

    /**
     * Display a list of clinics.
     *
     * @return Response
     */
    public function index()
    {
        $diagnosises = Diagnosis::get();

        return $this->okResponse(
            message: "API call successful",
            data: [
                'data' => DiagnosisResource::collection($diagnosises)
            ]
        );
    }

    /**
     * Store a newly created clinic in storage.
     *
     * @param StoreDiagnosisRequest $request
     * @return Response
     */
    public function store(StoreDiagnosisRequest $request)
    {
        $tdo = TDOFacade::make($request);

        $creationData = collect($tdo->asSnake())
            ->except([
                'services',
            ])
            ->toArray();

        $diagnosis = Diagnosis::create($creationData);

        // get services for calculate invoice.
        $services = Service::whereIn('id', $request->services)
            ->get();

        if ($services->count() > 0) {
            $totalAmount  = $services->sum('price');
            $invoiceItems = $services->map(function (Service $service) {
                return [
                    'service_id'        => $service->id,
                    'service_name'      => $service->name,
                    'amount'            => $service->price,
                ];
            })->toArray();

            $diagnosis->invoice()
                ->create(['total_amount' => $totalAmount])
                ->invoiceItems()
                ->createMany($invoiceItems);
        }

        return $this->okResponse(
            message: "Diagnosis created successfully",
            data: [
                'data' => DiagnosisResource::make($diagnosis)
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
        $diagnosis = Diagnosis::find($id);

        if (!$diagnosis) {
            return $this->badResponse(
                message: "Diagnosis not found"
            );
        }

        return $this->okResponse(
            message: "API call successful",
            data: [
                'data' => DiagnosisResource::make($diagnosis)
            ]
        );
    }

    /**
     * Update the specified clinic in storage.
     *
     * @param UpdateDiagnosisRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateDiagnosisRequest $request, $id)
    {
        $diagnosis = Diagnosis::find($id);

        if (!$diagnosis) {
            return $this->badResponse(
                message: "Diagnosis not found"
            );
        }

        $tdo = TDOFacade::make($request);
        $updateData = collect($tdo->asSnake())->except([])->toArray();

        $diagnosis->update($updateData);

        return $this->okResponse(
            message: "Diagnosis updated successfully",
            data: [
                'data' => DiagnosisResource::make($diagnosis)
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
        $diagnosis = Diagnosis::find($id);

        if (!$diagnosis) {
            return $this->badResponse(
                message: "Diagnosis not found"
            );
        }

        $diagnosis->delete();

        return $this->okResponse(
            message: "Diagnosis deleted successfully"
        );
    }
}
