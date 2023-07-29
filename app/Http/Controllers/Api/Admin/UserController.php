<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Api\Admin\UserService;
use App\Repositories\Api\UserRepository;
use App\Helpers\ResponseHelper;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    protected UserService $userService;
    protected UserRepository $userRepository;


    public function __construct(UserService $userService, UserRepository $userRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }


    public function index(Request $request): JsonResponse
    {
        $params = [];
        if (!empty($request->all())) {
            $params = [
                'orderBy' => $request->input('orderBy'),
                'perPage' => $request->input('perPage'),
            ];
        }

        if ($request->input('perPage')) {
            $posts = new UserCollection($this->userRepository->all($params));
        } else {
            $posts = UserResource::collection($this->userRepository->all($params));
        }

        return ResponseHelper::successWithMessageAndData(
            "Users fetched successfully",
            $posts
        );
    }


    public function show(User $user): JsonResponse
    {

        $user = $this->userRepository->find(['id' => $user->id]);

        if(!$user){
            return ResponseHelper::errorWithMessage(
                'An unexpected error occurred!',
                INTERNAL_SERVER_ERROR
            );
        }

        return ResponseHelper::successWithMessageAndData(
            'User fetched successfully',
            new UserResource($user)
        );
    }


    public function canPost(User $user): JsonResponse
    {
        $user = $this->userService->canPost($user->id);

        if(!$user){
            return ResponseHelper::errorWithMessage(
                'An unexpected error occurred!',
                INTERNAL_SERVER_ERROR
            );
        }

        return ResponseHelper::successWithMessageAndData(
            'User can now post',
            new UserResource($user)
        );
    }


    public function destroy(User $user): JsonResponse
    {

        $user = $this->userRepository->delete(['id' => $user->id]);

        if(!$user){
            return ResponseHelper::errorWithMessage(
                'An unexpected error occurred!',
                INTERNAL_SERVER_ERROR
            );
        }

        return ResponseHelper::successWithMessage(
            'u=Sser deleted successfully'
        );
    }
}
