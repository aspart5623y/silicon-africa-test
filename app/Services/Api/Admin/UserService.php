<?php
namespace App\Services\Api\Admin;

use App\Models\User;
use App\Repositories\Api\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function canPost($id): User | bool
    {
        if ($this->userRepository->canPost(['id' => $id])) {
            return $this->userRepository->find(['id' => $id]);
        } else {
            return false;
        }
    }
}
