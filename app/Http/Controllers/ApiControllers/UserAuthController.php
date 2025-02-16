<?php

namespace App\Http\Controllers\ApiControllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Jobs\SendWelcomeRegistrationEmailJob;
use App\Http\Requests\UserRegistrationRequest;
use Illuminate\Validation\ValidationException;

class UserAuthController extends Controller
{
    public function register(UserRegistrationRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);
        if (!$user) {
            return response()->json(['message' => 'Failed to register user.'], 400);
        }
        // SendWelcomeRegistrationEmailJob::dispatchAfterResponse();
        // SendWelcomeRegistrationEmailJob::dispatchSync();
        // SendWelcomeRegistrationEmailJob::dispatch_now();
        SendWelcomeRegistrationEmailJob::dispatch($user)
            ->onQueue('emails')
            ->delay(now()->addMinutes(10));

        return response()->json([
            'message' => 'User Created successfully',
            'user' => $user,
            'address' => $user->address,
        ], 200);
    }
    public function login(UserLoginRequest $request)
    {
        $data = $request->validated();
        logger('Request validated:', $request->validated());

        $user = User::with('addresses')->where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'error' => 'Invalid Credentials',
            ], 401);
        }
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        return response()->json([
            'success' => 'Logged in successfully',
            'user' => $user,

            'access_token' => $token,
        ]);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            "message" => "logged out",
        ]);
    }
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        // Validate the incoming request
        $data = $request->validated();
        logger('Request validated:', $request->validated());
        // Attempt to send the password reset link

        try {
            // Send the reset link
            $status = Password::sendResetLink(
                $request->only('email')
            );

            // Return a custom response based on the status
            if ($status === Password::RESET_LINK_SENT) {
                return response()->json([
                    'message' => 'Reset link sent successfully.',
                ], 200);
            }
            // If status isn't a success
            return response()->json([
                'message' => 'Failed to send reset link.',
            ], 400);
        } catch (ValidationException $e) {
            // Handle validation exception (e.g., email format or database issues)
            return response()->json([
                'message' => 'Invalid email format or other validation issues.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Handle any other exceptions that may arise
            return response()->json([
                'message' => 'An unexpected error occurred. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function resetPassword(ResetPasswordRequest $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email|exists:users,email', // Ensure the email exists in the DB
            'password' => 'required|min:8|confirmed', // Password confirmation validation
            'token' => 'required|string', // Ensure the token is provided
        ]);

        try {
            // Attempt the password reset using Laravel's built-in method
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    // If token is valid, update the user's password
                    $user->forceFill([
                        'password' => Hash::make($password),
                    ])->setRememberToken(Str::random(60));
                    $user->save();
                    event(new PasswordReset($user));
                }
            );

            // Check if the password was successfully reset
            if ($status === Password::PASSWORD_RESET) {
                return response()->json([
                    'message' => 'Password reset successfully.',
                ], 200);
            }

            // If the token is invalid or expired
            return response()->json([
                'message' => 'Invalid or expired reset token.',
            ], 400);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Handle any other exceptions that may arise
            return response()->json([
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
