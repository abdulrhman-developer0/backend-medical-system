<?php

namespace Modules\User\Http\Controllers;

use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\ChangePasswordRequest;
use Modules\User\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    use ApiResponses;

    public function __construct()
    {
        $this->middleware('auth:sanctum')
        ->only(['index', 'changePassword', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return $this->okResponse(
            message: "Get User data successfuly",
            data: [
                'data'  => auth()->user()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(LoginRequest $request)
    {
        $user = User::firstWhere('email', $request->email);

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return $this->badResponse(
                message: "Invalid email or password"
            );
        }


        $tokenName = $user->email . ' - ' . $request->ip();
        $token = $user->createToken($tokenName);

        return $this->okResponse(
            message: "Create token successfuly",
            data: [
                'type'   => $user->type,
                'token'  => $token->plainTextToken
            ]
        );
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();

        if (! Hash::check($request->password, $user->password)) {
            return $this->badResponse(
                message: "Invalid old password"
            );
        }

        $user->password = $request->newPassword;
        $saved = $user->save();

        return $this->okResponse(
            message: "Changed password successfuly",
            data: $saved
        );
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $token = $request->user()->currentAccessToken();

        return $this->okResponse(
            message: "Invlidated token successfuly",
            data: $token->delete()
        );
    }
}
