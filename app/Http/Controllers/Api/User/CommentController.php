<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Api\User\CommentService;
use App\Repositories\Api\CommentRepository;
use App\Helpers\ResponseHelper;
use App\Repositories\Api\PostRepository;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    protected CommentService $commentService;
    protected CommentRepository $commentRepository;
    protected PostRepository $postRepository;


    public function __construct(CommentService $commentService, CommentRepository $commentRepository, PostRepository $postRepository)
    {
        $this->commentService = $commentService;
        $this->commentRepository = $commentRepository;
        $this->postRepository = $postRepository;
    }

    public function index(Request $request, Post $post): JsonResponse
    {
        $params = [];

        if (!empty($request->all())) {
            $params = [
                'orderBy' => $request->input('orderBy'),
                'perPage' => $request->input('perPage'),
            ];
        }

        $params['where'] = ["post_id:".$post->id];

        if ($request->input('perPage')) {
            $comments = new CommentCollection($this->postRepository->comments($post, $params));
        } else {
            $comments = CommentResource::collection($this->postRepository->comments($post, $params));
        }


        return ResponseHelper::successWithMessageAndData(
            "comments fetched successfully",
            $comments
        );
    }

    public function store(CommentRequest $commentRequest, Post $post): JsonResponse
    {
        $comment = $this->commentService->save($commentRequest->validated(), $post->id);

        return ResponseHelper::successWithMessageAndData(
            'New Comment added successfully',
            new CommentResource($comment)
        );
    }

    public function show($post, Comment $comment): JsonResponse
    {

        $comment = $this->commentRepository->find(['id' => $comment->id]);

        if(!$comment){
            return ResponseHelper::errorWithMessage(
                'An unexpected error occurred!',
                INTERNAL_SERVER_ERROR
            );
        }

        return ResponseHelper::successWithMessageAndData(
            'Comment fetched successfully',
            new CommentResource($comment)
        );
    }


    public function update(CommentRequest $commentRequest, $post, Comment $comment): JsonResponse
    {
        $comment = $this->commentService->edit($commentRequest->validated(), $comment->id);

        if(!$comment){
            return ResponseHelper::errorWithMessage(
                'An unexpected error occurred!',
                INTERNAL_SERVER_ERROR
            );
        }

        return ResponseHelper::successWithMessageAndData(
            'Comment updated successfully',
            new CommentResource($comment)
        );
    }

    public function destroy($post, Comment $comment): JsonResponse
    {

        $comment = $this->commentRepository->delete(['id' => $comment->id]);

        if(!$comment){
            return ResponseHelper::errorWithMessage(
                'An unexpected error occurred!',
                INTERNAL_SERVER_ERROR
            );
        }

        return ResponseHelper::successWithMessage(
            'Comment deleted successfully'
        );
    }
}
