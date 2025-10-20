<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Modules\User\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Gate;
use Modules\User\Actions\CreateUserAction;
use Modules\User\Http\Requests\CreateUserRequest;
use Modules\User\Http\Resources\UserResource;
use Modules\User\Http\Requests\SearchUserRequest;
use Modules\User\Actions\SearchUserAction;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchUserRequest $request, SearchUserAction $action): JsonResponse
    {
        $users = $action->execute($request->validated());

        return UserResource::collection($users)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request, CreateUserAction $action): JsonResponse
    {
        $user = $action->execute($request->name, $request->email, $request->password);

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Show the specified resource.
     */
    public function show(int $userId): JsonResponse
    {
        $user = User::where('id', $userId)->first();
        if (empty($user)) {
            throw new NotFoundHttpException('User not found');
        }

        Gate::authorize('grant-user', $user);

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, int $userId): JsonResponse
    {
        $user = User::where('id', $userId)->first();
        if (empty($user)) {
            throw new NotFoundHttpException('User not found');
        }

        Gate::authorize('grant-user', $user);

        $user->update($request->validated());

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $userId): JsonResponse
    {
        $user = User::where('id', $userId)->first();
        if (empty($user)) {
            throw new NotFoundHttpException('User not found');
        }

        Gate::authorize('grant-user', $user);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
