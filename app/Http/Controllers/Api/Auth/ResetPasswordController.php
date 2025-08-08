<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PasswordResetCodeNotification;
use App\Traits\ApiResponse;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Post(
     *     path="/api/forgot-password",
     *     summary="Send password reset code",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Reset code sent"),
     *     @OA\Response(response=422, description="Invalid email")
     * )
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        // Generate a 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store the code in the password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($code),
                'created_at' => now()
            ]
        );

        // Send the notification with the code
        $user->notify(new PasswordResetCodeNotification($code));

        return $this->successResponse(['email' => $user->email], 'Password reset code sent');
    }

    /**
     * @OA\Post(
     *     path="/api/verify-reset-code",
     *     summary="Verify password reset code",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"code","email"},
     *             @OA\Property(property="code", type="string"),
     *             @OA\Property(property="email", type="string", format="email")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Code verified successfully"),
     *     @OA\Response(response=400, description="Invalid or expired code")
     * )
     */
    public function verifyResetCode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
            'email' => ['required', 'email'],
        ]);

        // Get the reset record
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            return $this->errorResponse('Invalid reset code', 400);
        }

        // Check if the code is valid
        if (!Hash::check($request->code, $resetRecord->token)) {
            return $this->errorResponse('Invalid reset code', 400);
        }

        // Check if the code is expired (1 hour)
        if (now()->diffInMinutes($resetRecord->created_at) > 60) {
            return $this->errorResponse('Reset code has expired', 400);
        }

        return $this->successResponse(null, 'Reset code verified successfully');
    }

    /**
     * @OA\Post(
     *     path="/api/reset-password",
     *     summary="Reset password with code",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"code","email","password","password_confirmation"},
     *             @OA\Property(property="code", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password"),
     *             @OA\Property(property="password_confirmation", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Password reset successful"),
     *     @OA\Response(response=422, description="Invalid code or validation errors")
     * )
     */
    public function reset(Request $request)
    {
        $request->validate([
            // 'code' => ['required', 'string', 'size:6'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // Get the reset record
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            return $this->errorResponse('Invalid reset code', 400);
        }

        // // Check if the code is valid
        // if (!Hash::check($request->code, $resetRecord->token)) {
        //     return $this->errorResponse('Invalid reset code', 400);
        // }

        // // Check if the code is expired (1 hour)
        // if (now()->diffInMinutes($resetRecord->created_at) > 60) {
        //     return $this->errorResponse('Reset code has expired', 400);
        // }

        // Get the user
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        // Reset the password
        $user->forceFill([
            'password' => Hash::make($request->password)
        ])->setRememberToken(Str::random(60));

        $user->save();

        // Delete the reset record
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        event(new PasswordReset($user));

        return $this->successResponse(null, 'Password has been reset successfully');
    }
}
