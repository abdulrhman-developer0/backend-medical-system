<?php

namespace Modules\Medical\Http\Controllers;

use App\Facades\TDOFacade;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Medical\Entities\Diagnosis;
use Modules\Medical\Entities\Service;
use Modules\Medical\Entities\Setting;
use Modules\Medical\Http\Requests\StoreDiagnosisRequest;
use Modules\Medical\Http\Requests\UpdateDiagnosisRequest;
use Modules\Medical\Transformers\DiagnosisResource;

class DiagnosisController extends Controller
{
    use ApiResponses;

    public function __construct()
    {
        $this->middleware(['type:admin,doctor'])
            ->only([
                'index',
                'store',
                'update',
            ]);
    }

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
        // if (Diagnosis::whereAppointmentId($request->appointmentId)->exists()) {
        //     return $this->badResponse(
        //         message: "لا يمكنك تشخيص هذا الججز مرة اخرة يمكنك تعديله فقط"
        //     );
        // }

        $tdo = TDOFacade::make($request);

        $creationData = collect($tdo->asSnake())
            ->except([
                'services',
            ])
            ->toArray();

        $diagnosis = Diagnosis::create($creationData);
        $appointment = $diagnosis->appointment;

        $invoiceSettings = Setting::find('invoiceSettings')?->value;

        if (str_starts_with($appointment->patient->national_id, '2')) {
            $taxRate = $invoiceSettings['taxRate'] ?? 0;
        } else {
            $taxRate = 0;
        }


        // get services for calculate invoice.
        $services = Service::whereIn('id', $request->services)
            ->get();

        //  generate invoice items form services details.
        $invoiceItems = $services->map(function (Service $service) use ($taxRate) {
            $tax = ($service->price / 100) * $taxRate;

            return [
                'service_id'        => $service->id,
                'service_name'      => $service->name,
                'tax'              => $tax,
                'amount'            => $service->price,
            ];
        });

        if ($appointment->visit_type == 'examination') {

            // The name of service.
            $name = $appointment->doctor?->speciality?->name;;

            // The examination coset of doctor speciality.
            $cost = $appointment->doctor?->speciality?->examination_cost;

            // calculate the tax.
            $tax = ($cost / 100) * $taxRate;

            $invoiceItems = collect([
                [
                    'service_id'        => null,
                    'service_name'      => $name,
                    'tax'              => $tax,
                    'amount'            => $cost,
                ]
            ])->merge($invoiceItems);
        } elseif ($appointment->visit_type == 'analysis') {

            // The service of analysis.
            $service = $appointment->analysis;

            // calculate the tax.
            $tax = ($service->price / 100) * $taxRate;

            $invoiceItems = collect([
                [
                    'service_id'        => $service->id,
                    'service_name'      => $service->name,
                    'tax'              => $tax,
                    'amount'            => $service->price,
                ]
            ])->merge($invoiceItems);
        }





        $totalTaxes   = $invoiceItems->sum('tax');
        $totalAmount  = $invoiceItems->sum('amount') + $totalTaxes;
        $discount     = ($totalAmount / 100)  * ($appointment->discount ?? 0);

        $diagnosis->invoice()
            ->create([
                'total_taxes'  => $totalTaxes,
                'discount'     => $discount,
                'total_amount' => $totalAmount - $discount
            ])
            ->invoiceItems()
            ->createMany($invoiceItems->toArray());

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
