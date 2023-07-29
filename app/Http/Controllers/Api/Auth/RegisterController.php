<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Services\Api\Auth\RegisterService;

class RegisterController extends Controller
{
    protected $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }


    public function register(RegisterRequest $registerRequest)
    {
        return $this->registerService->register($registerRequest->validated());
    }
}
