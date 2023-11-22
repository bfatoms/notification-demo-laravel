<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Notification;
use App\Models\UserSetting;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegistrationRequest $request)
    {
        try {
            // Simulate an error condition (for testing purposes), we put it here so that code coverage can see it
            // instead of mocking in the AuthTest
            if ($request->force500) {
                abort(500, 'Internal Server Error');
            }

            DB::beginTransaction();

            $user = User::create(array_merge(
                Arr::except($request->validated(), 'password'),
                [ 'password' => Hash::make($request->password) ]
            ));

            DB::commit();

            return response()->json([
                'message' => 'Successfully created user!',
                'data' => [
                    'token'=> $user->createToken('registrationToken')->plainTextToken,
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Wooops! Something went wrong', 'data' => []], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'data' => [
                'user' => $user,
                'token' => $user->createToken('authToken')->plainTextToken
            ]
        ]);
    }

    public function profile()
    {
        $user = auth()->user();

        return response()->json([
            'message' => 'User profile retrieved successfully',
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function settings()
    {
        return response()->json([
            'message' => 'Settings retrieved successfully',
            'data' => [
                'settings' => UserSetting::paginate(20)
            ]
        ]);
    }

    public function updateSettings(UpdateSettingRequest $request, UserSetting $setting)
    {
        $setting->update($request->validated());

        return response()->json([
            'message' => 'Settings updated successfully',
            'data' => [
                'settings' => $setting->refresh()
            ]
        ]);
    }

    public function notifications()
    {
        return response()->json([
            'message' => 'Settings retrieved successfully',
            'data' => [
                'notifications' => Notification::paginate(20)
            ]
        ]);
    }
}
