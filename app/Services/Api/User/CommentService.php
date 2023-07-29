<?php
namespace App\Services\Api\User;

use App\Models\Comment;
use App\Repositories\Api\CommentRepository;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    protected CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository){
        $this->commentRepository = $commentRepository;
    }

    public function save(array $commentData, string $post_id): Comment | bool
    {
        $user = auth()->guard('user-api')->user();
        $commentData['user_id'] = $user->profileable->id;
        $commentData['post_id'] = $post_id;

        return $this->commentRepository->create($commentData);
    }

    public function edit(array $commentData, $id): Comment | bool
    {
        if ($this->commentRepository->update(['id' => $id], $commentData)) {
            return $this->commentRepository->find(['id' => $id]);
        } else {
            return false;
        }
    }
}
