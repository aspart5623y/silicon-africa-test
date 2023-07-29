<?php
namespace App\Services\Api\User;

use App\Models\Post;
use App\Repositories\Api\PostRepository;
use Illuminate\Support\Facades\Auth;

class PostService
{
    protected PostRepository $postRepository;

    public function __construct(PostRepository $postRepository){
        $this->postRepository = $postRepository;
    }

    public function save(array $postData): Post | bool
    {
        $user = auth()->guard('user-api')->user();
        $postData['user_id'] = $user->profileable->id;
        if (!$user->profileable->can_post){
            return false;
        }

        return $this->postRepository->create($postData);
    }

    public function edit(array $postData, $id): Post | bool
    {
        $user = auth()->guard('user-api')->user();
        $postData['user_id'] = $user->profileable->id;

        if ($this->postRepository->update(['id' => $id, 'user_id' => $postData['user_id']], $postData)) {
            return $this->postRepository->find(['id' => $id]);
        } else {
            return false;
        }
    }
}
