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
     * عرض قائمة العيادات.
     *
     * @return Response
     */
    public function index()
    {
        $clinics = Clinic::all();

        return $this->okResponse(
            message: "تم استدعاء API بنجاح",
            data: [
                'clinics' => $clinics
            ]
        );
    }

    /**
     * تخزين عيادة جديدة في التخزين.
     *
     * @param StoreClinicRequest $request
     * @return Response
     */
    public function store(StoreClinicRequest $request)
    {
        $tdo = TDOFacade::make($request);

        $creationData = collect($tdo->asSnake())
            ->except([]) // تحديد أي حقول لاستبعادها إذا لزم الأمر
            ->toArray();

        $clinic = Clinic::create($creationData);

        return $this->okResponse(
            message: "تم إنشاء العيادة بنجاح",
            data: $clinic
        );
    }

    /**
     * عرض العيادة المحددة.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $clinic = Clinic::find($id);

        if (!$clinic) {
            return $this->badResponse(
                message: "لم يتم العثور على العيادة"
            );
        }

        return $this->okResponse(
            message: "تم استدعاء API بنجاح",
            data: $clinic
        );
    }

    /**
     * تحديث العيادة المحددة في التخزين.
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
                message: "لم يتم العثور على العيادة"
            );
        }

        $tdo = TDOFacade::make($request);
        $updateData = collect($tdo->asSnake())->except([])->toArray();

        $clinic->update($updateData);

        return $this->okResponse(
            message: "تم تحديث العيادة بنجاح",
            data: $clinic
        );
    }

    /**
     * إزالة العيادة المحددة من التخزين.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $clinic = Clinic::find($id);

        if (!$clinic) {
            return $this->badResponse(
                message: "لم يتم العثور على العيادة"
            );
        }

        $clinic->delete();

        return $this->okResponse(
            message: "تم حذف العيادة بنجاح"
        );
    }
}
