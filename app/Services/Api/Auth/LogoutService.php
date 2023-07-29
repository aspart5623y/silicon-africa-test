<?php
namespace App\Services\Api\Auth;

use App\Helpers\ResponseHelper;

class LogoutService
{
    protected $user_role;

    public function logout($user_role)
    {
        $this->user_role = $user_role . '-api';

        if (auth()->check()) {
            if (auth()->guard($this->user_role)->user()->token()->revoke()) {
                return ResponseHelper::successWithMessage(
                    "You have been logged out successfully. Enter your credentials to login again."
                );
            }
        }

        return ResponseHelper::errorWithMessage(
            "An unexpected error occured.",
            INTERNAL_SERVER_ERROR
        );
    }
}
