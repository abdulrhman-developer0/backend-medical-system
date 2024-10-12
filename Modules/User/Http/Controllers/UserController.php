<?php

namespace Modules\User\Http\Controllers;

use App\Facades\TDOFacade;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\StoreUserRequest;
use Modules\User\Http\Requests\UpdateUserRequest;
use Modules\User\Transformers\UserResource;

class UserController extends Controller
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
        $query = User::latest();

        if ($request->type) {
            $query->whereType($request->type);
        }


        $users  = $query->get();

        return $this->okResponse(
            message: "API call successful",
            data: [
                'data' => UserResource::collection($users)
            ]
        );
    }

    /**
     * Store a newly created clinic in storage.
     *
     * @param StoreUserRequest $request
     * @return Response
     */
    public function store(StoreUserRequest $request)
    {
        $tdo = TDOFacade::make($request);

        $creationData = collect($tdo->asSnake())
            ->except([])
            ->toArray();

        // hashing the password
        $creationData['password'] = Hash::make($creationData['password']);

        $user = User::create($creationData);

        return $this->okResponse(
            message: "User created successfully",
            data: [
                'data' => UserResource::make($user)
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
        $user = User::find($id);

        if (!$user) {
            return $this->badResponse(
                message: "User not found"
            );
        }

        return $this->okResponse(
            message: "API call successful",
            data: [
                'data' => UserResource::make($user)
            ]
        );
    }

    /**
     * Update the specified clinic in storage.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->badResponse(
                message: "User not found"
            );
        }

        $tdo = TDOFacade::make($request);
        $updateData = collect($tdo->asSnake())->except([])->toArray();
        // hashing the password
        $updateData['password'] = Hash::make($updateData['password']);

        $user->update($updateData);

        return $this->okResponse(
            message: "User updated successfully",
            data: [
                'data' => UserResource::make($user)
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
        $user = User::find($id);

        if (!$user) {
            return $this->badResponse(
                message: "User not found"
            );
        }

        $user->delete();

        return $this->okResponse(
            message: "User deleted successfully"
        );
    }
}
