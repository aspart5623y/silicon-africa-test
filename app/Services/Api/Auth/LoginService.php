<?php
namespace App\Services\Api\Auth;

use App\Models\User;
use App\Models\Admin;
use App\Models\Profile;
use App\Helpers\ResponseHelper;

class LoginService
{
    public function login(array $loginData)
    {
        $profile = Profile::where('email', $loginData['email'])->first();

        if ($profile) {
            if ($profile->profileable_type === 'user') {
                if (auth()->guard('user')->attempt($loginData)) {
                    $user_profile = Profile::findOrFail(auth()->guard('user')->user()->id);
                    $user_data = User::findOrFail(auth()->guard('user')->user()->profileable_id);
                    $token = auth()->guard('user')->user()->createToken('My Token', ['user'])->accessToken;
                    $user_profile->api_token = $token;
                    $user_profile->save();
                    $user_data->profile = $user_profile;

                    return ResponseHelper::successWithMessageAndData(
                        'Authentication Successful',
                        $user_data,
                        OK
                    );

                } else {
                    return ResponseHelper::errorWithMessageAndData(
                        'Authentication Failed',
                        [
                            'password' => ['Incorrect password']
                        ],
                        UNPROCESSABLE_ENTITY
                    );
                }

            } else if ($profile->profileable_type === 'admin') {

                if (auth()->guard('admin')->attempt($loginData)) {

                    $user_profile = Profile::findOrFail(auth()->guard('admin')->user()->id);
                    $user_data = Admin::findOrFail(auth()->guard('admin')->user()->profileable_id);
                    $token = auth()->guard('admin')->user()->createToken('My Token', ['admin'])->accessToken;
                    $user_profile->api_token = $token;
                    $user_profile->save();

                    $user_data->profile = $user_profile;

                    return ResponseHelper::successWithMessageAndData(
                        'Authentication Successful',
                        $user_data,
                        OK
                    );

                } else {
                    return ResponseHelper::errorWithMessageAndData(
                        'Authentication Failed',
                        [
                            'password' => ['Incorrect password']
                        ],
                        UNPROCESSABLE_ENTITY
                    );
                }
            }
        } else {
            return ResponseHelper::errorWithMessage(
                'Authentication Failed',
                'User Role does not exist',
                NOT_FOUND
            );
        }
    }
}
