<?php
namespace App\Services\Api\Admin;

use App\Models\Post;
use App\Repositories\Api\PostRepository;
use Illuminate\Support\Facades\Auth;

class PostService
{
    protected PostRepository $postRepository;

    public function __construct(PostRepository $postRepository){
        $this->postRepository = $postRepository;
    }

    public function edit(array $postData, $id): Post | bool
    {
        if ($this->postRepository->update(['id' => $id], $postData)) {
            return $this->postRepository->find(['id' => $id]);
        } else {
            return false;
        }
    }
}
