<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Api\Auth\LogoutService;


class LogoutController extends Controller
{
    protected $logoutService;

    public function __construct(LogoutService $logoutService)
    {
        $this->logoutService = $logoutService;
    }

    public function logout()
    {
        return $this->logoutService->logout('user');
    }
}
