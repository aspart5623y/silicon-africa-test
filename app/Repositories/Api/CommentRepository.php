<?php
namespace App\Repositories\Api;

use App\Factory\FactoryRepository;
use App\Models\Comment;

class CommentRepository extends FactoryRepository
{
    public function __construct(Comment $comment)
    {
        parent::__construct($comment);
    }

    // public function newComment($post, $commentData)
    // {
        // $query = $post->comments();

        // if (isset($params['orderBy'])) {
        //     $orderBy = explode(':', $params['orderBy']);
        //     $query->orderBy($orderBy[0], $orderBy[1] ?? 'asc');
        // }

        // if (isset($params['perPage'])) {
        //     return $query->paginate($params['perPage'] ?? 10);
        // }

        // return $post->comments;
    // }
}
