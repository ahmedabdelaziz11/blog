<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\VerifyCodeRequest;
use App\Http\Traits\Api\ApiResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponseTrait;
    
    public function register(RegisterUserRequest $request)
    {
        $verificationCode = rand(100000, 999999);
        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'verification_code' => $verificationCode,
        ]);

        return $this->apiResponse(
            [ 'user' => $user, 'access_token' => $user->createToken('auth_token')->plainTextToken ],
            'ok',
            200
        );
    }

    public function login(LoginUserRequest $request)
    {
        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user || !Hash::check($request->password, $user->password) || !$user->is_verified) {
            return $this->apiResponse(null,'Unauthorized',401);
        }

        return $this->apiResponse(
            [ 'user' => $user, 'access_token' => $user->createToken('auth_token')->plainTextToken ],
            'ok',
            200
        );
    }

    public function verify(VerifyCodeRequest $request)
    {
        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return $this->apiResponse(null,'User not found',404);
        }

        if ($user->verification_code === $request->verification_code) {
            $user->update([
                'is_verified' => true,
                'verification_code' => null,
            ]);

            return $this->apiResponse(null,'Account verified successfully',200);
        } else {
            return $this->apiResponse(null,'Verification code is incorrect',422);
        }
    }
}
