<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    use ApiResponse;

    public function status(Request $request)
    {
        return $this->successResponse([
            'verified' => $request->user()->hasVerifiedEmail(),
            'email' => $request->user()->email
        ]);
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return $this->successResponse(null, 'Email verified successfully');
    }

    public function send(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->errorResponse('Email already verified', 400);
        }

        $request->user()->sendEmailVerificationNotification();
        return $this->successResponse(null, 'Verification link sent');
    }
}
