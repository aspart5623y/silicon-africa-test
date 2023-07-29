<?php
namespace App\Services\Api\Admin;

use App\Models\Comment;
use App\Repositories\Api\CommentRepository;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    protected CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository){
        $this->commentRepository = $commentRepository;
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
