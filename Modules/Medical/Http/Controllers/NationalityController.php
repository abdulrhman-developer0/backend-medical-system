<?php

namespace Modules\Medical\Http\Controllers;

use App\Traits\ApiResponses;
use Illuminate\Routing\Controller;
use Modules\Medical\Entities\Nationality;

class NationalityController extends Controller
{
    use ApiResponses;

    public function __invoke()
    {
        $nationalities = Nationality::all();

        return $this->okResponse(
            message: "Success api call",
            data: [
                'data' => $nationalities
            ]
        );
    }
}
