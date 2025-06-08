<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\EmailVerificationCodeNotification;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailVerificationController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Get(
     *     path="/api/email/verify/status",
     *     summary="Get email verification status",
     *     tags={"Authentication"},
     *     security={"sanctum": {}},
     *     @OA\Response(response=200, description="Email verification status")
     * )
     */
    public function status(Request $request)
    {
        return $this->successResponse([
            'verified' => $request->user()->hasVerifiedEmail(),
            'email' => $request->user()->email
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/email/verify",
     *     summary="Verify email with code",
     *     tags={"Authentication"},
     *     security={"sanctum": {}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"code"},
     *             @OA\Property(property="code", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Email verified successfully"),
     *     @OA\Response(response=400, description="Invalid or expired code"),
     *     @OA\Response(response=422, description="Validation errors")
     * )
     */
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|size:6',
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $user = User::whereEmail($request->email)->first();

        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        if ($user->hasVerifiedEmail()) {
            return $this->errorResponse('Email already verified', 400);
        }

        if ($user->verification_code !== $request->code) {
            return $this->errorResponse('Invalid verification code', 400);
        }

        if ($user->verification_code_expires_at->isPast()) {
            return $this->errorResponse('Verification code has expired', 400);
        }

        $user->markEmailAsVerified();
        $user->verification_code = null;
        $user->verification_code_expires_at = null;
        $user->save();
        return $this->successResponse([
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ], 'Email verified successfully');
    }

    /**
     * @OA\Post(
     *     path="/api/email/verification-notification",
     *     summary="Send verification code",
     *     tags={"Authentication"},
     *     security={"sanctum": {}},
     *     @OA\Response(response=200, description="Verification code sent"),
     *     @OA\Response(response=400, description="Email already verified")
     * )
     */
    public function send(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return $this->errorResponse('Email already verified', 400);
        }

        $code = $user->generateVerificationCode();
        $user->notify(new EmailVerificationCodeNotification($code));

        return $this->successResponse(null, 'Verification code sent');
    }
}
