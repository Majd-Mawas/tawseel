<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Get(
     *     path="/api/email/verify",
     *     summary="Get email verification status",
     *     tags={"Authentication"},
     *     security={"sanctum": {}},
     *     @OA\Response(response=200, description="Email verification status"),
     *     @OA\Response(response=401, description="Unauthenticated")
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
     * @OA\Get(
     *     path="/api/email/verify/{id}/{hash}",
     *     summary="Verify email address",
     *     tags={"Authentication"},
     *     security={"sanctum": {}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="hash",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Email verified successfully"),
     *     @OA\Response(response=401, description="Invalid verification link")
     * )
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return $this->successResponse(null, 'Email verified successfully');
    }

    /**
     * @OA\Post(
     *     path="/api/email/verification-notification",
     *     summary="Resend verification email",
     *     tags={"Authentication"},
     *     security={"sanctum": {}},
     *     @OA\Response(response=200, description="Verification link sent"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function send(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->errorResponse('Email already verified', 400);
        }

        $request->user()->sendEmailVerificationNotification();
        return $this->successResponse(null, 'Verification link sent');
    }
}
