<?php
namespace App\Repositories\Api;

use App\Factory\FactoryRepository;
use App\Models\User;

class UserRepository extends FactoryRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function canPost(array $attributes): User | bool
    {
        return $this->model->where($attributes)->update([
            'can_post' => true
        ]);
    }

}
