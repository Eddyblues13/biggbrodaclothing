<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'max:20'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],


                'agreeTerms' => ['accepted'],
            ], [
                'agreeTerms.accepted' => 'You must accept the Terms of Service',

                'password.mixed' => 'Password must contain both uppercase and lowercase letters',
                'password.numbers' => 'Password must contain at least one number',
                'password.symbols' => 'Password must contain at least one symbol',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'formData' => $request->except('password', 'password_confirmation')
                ], 422);
            }

            // Create user
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),

            ]);

            // Handle newsletter subscription
            if ($request->has('newsletter')) {
                try {
                    Subscriber::updateOrCreate(
                        ['email' => $request->email],
                        [
                            'first_name' => $request->first_name,
                            'last_name' => $request->last_name

                        ]
                    );

                    Log::info('User subscribed to newsletter', [
                        'user_id' => $user->id,
                        'email' => $user->email
                    ]);
                } catch (\Exception $e) {
                    Log::error('Newsletter subscription failed: ' . $e->getMessage(), [
                        'user_id' => $user->id,
                        'email' => $user->email
                    ]);
                }
            }

            // Log registration
            Log::info('New user registered', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Send email verification if needed
            // $user->sendEmailVerificationNotification();

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! Welcome to BIGGBRODA.',
                'redirect' => route('home')
            ]);
        } catch (\Exception $e) {
            Log::error('Registration Error: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }
}
