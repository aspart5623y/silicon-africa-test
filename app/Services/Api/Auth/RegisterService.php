<?php
namespace App\Services\Api\Auth;

use App\Models\User;
use App\Models\Profile;
use App\Repositories\Api\Admin\UserRepository;
use App\Repositories\Api\Admin\ProfileRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    protected UserRepository $userRepository;
    protected ProfileRepository $profileRepository;
    protected LoginService $loginService;

    public function __construct(UserRepository $userRepository, ProfileRepository $profileRepository, LoginService $loginService){
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
        $this->loginService = $loginService;
    }


    public function register(array $registerData)
    {
        $userAccount = $this->userRepository->create([
            "first_name" => $registerData["first_name"],
            "last_name" => $registerData["last_name"],
            "phone" => $registerData["phone"]
        ]);

        $userAccount->profile()->create([
            "email" => $registerData["email"],
            "password" => Hash::make($registerData['password'])
        ]);

        return $this->loginService->login([
            "email" => $registerData['email'],
            "password" => $registerData["password"]
        ]);
    }


}
