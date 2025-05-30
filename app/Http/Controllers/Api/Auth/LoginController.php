<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

class LoginController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Authenticate user and generate token",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="user", type="object")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials")
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;

            return $this->successResponse([
                'user' => $user,
                'token' => $token
            ], 'Logged in successfully');
        }

        return $this->errorResponse('Invalid credentials', 401);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout user and invalidate token",
     *     tags={"Authentication"},
     *     security={"sanctum": {}},
     *     @OA\Response(response=200, description="Successfully logged out"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse(null, 'Logged out successfully');
    }
}
