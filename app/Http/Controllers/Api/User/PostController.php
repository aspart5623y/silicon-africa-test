<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Api\User\PostService;
use App\Repositories\Api\PostRepository;
use App\Helpers\ResponseHelper;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    protected PostService $postService;
    protected PostRepository $postRepository;


    public function __construct(PostService $postService, PostRepository $postRepository)
    {
        $this->postService = $postService;
        $this->postRepository = $postRepository;
    }


    public function index(Request $request): JsonResponse
    {
        $params = [];
        $user = auth()->guard('user-api')->user();

        if (!empty($request->all())) {
            $params = [
                'orderBy' => $request->input('orderBy'),
                'perPage' => $request->input('perPage'),
            ];
        }

        $params['where'] = ["user_id:".$user->profileable->id];

        if ($request->input('perPage')) {
            $posts = new PostCollection($this->postRepository->all($params));
        } else {
            $posts = PostResource::collection($this->postRepository->all($params));
        }

        return ResponseHelper::successWithMessageAndData(
            "posts fetched successfully",
            $posts
        );
    }


    public function store(PostRequest $postRequest): JsonResponse
    {
        $post = $this->postService->save($postRequest->validated());

        if(!$post){
            return ResponseHelper::errorWithMessage(
                'You cannot create posts until this feature has been enabled by the admin.',
                BAD_REQUEST
            );
        }

        return ResponseHelper::successWithMessageAndData(
            'New Post added successfully',
            new PostResource($post)
        );
    }

    public function show(Post $post): JsonResponse
    {

        $post = $this->postRepository->find(['id' => $post->id]);

        if(!$post){
            return ResponseHelper::errorWithMessage(
                'An unexpected error occurred!',
                INTERNAL_SERVER_ERROR
            );
        }

        return ResponseHelper::successWithMessageAndData(
            'Post fetched successfully',
            new PostResource($post)
        );
    }


    public function update(PostRequest $postRequest, Post $post): JsonResponse
    {
        $post = $this->postService->edit($postRequest->validated(), $post->id);

        if(!$post){
            return ResponseHelper::errorWithMessage(
                'An unexpected error occurred!',
                INTERNAL_SERVER_ERROR
            );
        }

        return ResponseHelper::successWithMessageAndData(
            'Post updated successfully',
            new PostResource($post)
        );
    }

    public function destroy(Post $post): JsonResponse
    {
        $user = auth()->guard('user-api')->user();
        $user_id = $user->profileable->id;

        $post = $this->postRepository->delete(['id' => $post->id, 'user_id' => $user_id]);

        if(!$post){
            return ResponseHelper::errorWithMessage(
                'An unexpected error occurred!',
                INTERNAL_SERVER_ERROR
            );
        }

        return ResponseHelper::successWithMessage(
            'Post deleted successfully'
        );
    }
}
