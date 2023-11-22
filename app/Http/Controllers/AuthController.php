<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class AuthController extends Controller
{
    public function register(RegistrationRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create(array_merge(
                Arr::except($request->validated(), 'password'),
                [ 'password' => bcrypt($request->password) ]
            ));

            DB::commit();

            return response()->json([
                'message' => 'Successfully created user!',
                'data' => [
                    'accessToken'=> $user->createToken('notification_token')->plainTextToken,
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Wooops! Something went wrong', 'data' => []], 500);
        }
    }

    public function login() {

    }
}
