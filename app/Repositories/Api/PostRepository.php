<?php
namespace App\Repositories\Api;

use App\Factory\FactoryRepository;
use App\Models\Post;

class PostRepository extends FactoryRepository
{
    public function __construct(Post $post)
    {
        parent::__construct($post);
    }

    public function comments($post, $params = [])
    {
        $query = $post->comments();

        if (isset($params['orderBy'])) {
            $orderBy = explode(':', $params['orderBy']);
            $query->orderBy($orderBy[0], $orderBy[1] ?? 'asc');
        }

        if (isset($params['perPage'])) {
            return $query->paginate($params['perPage'] ?? 10);
        }

        return $post->comments;
    }
}
