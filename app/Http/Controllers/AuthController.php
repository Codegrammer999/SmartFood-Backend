<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * function to register a user
     */
    public function register(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string|min:5|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:255|confirmed',
            'referral_id' => 'nullable|string|min:10|max:10'
        ]);

        if ($data->fails())
        {
            return response()->json([
                'errors' => $data->errors()
            ], 422);
        }

        if ($request->filled('referral_id'))
        {
            $userWithIncomingReferralId = User::where('referral_id', $request->referral_id)->first();

            if (!$userWithIncomingReferralId)
            {
                return response()->json([
                    'referralErr' => 'User with referral id ' . $request->referral_id .' not found!',
                    'success' => false
                ]);
            }

            $pointsToAdd = 20;
            $userWithIncomingReferralId->points += $pointsToAdd;
            $userWithIncomingReferralId->save();

            event(new NewReferral($userWithIncomingReferralId, $pointsToAdd));
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'points' => 20,
            'role' => 'user'
        ]);

        return response()->json([
            'message' => 'New user created',
            'success' => true
        ], 201);
    }

    /**
     * function to login a user
     */
    public function login(Request $request)
    {
        $data = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required|min:5|max:255'
        ]);

        if ($data->fails())
        {
            return response()->json([
                'errors' => $data->errors()
            ],422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password))
        {
            return response()->json([
                'message' => 'Incorrect email or Password',
                'success' => false
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'success' => true,
            'user' => $user
        ], 200);
    }

    /**
     * function to reset a user password
     */
    public function resetPassword(Request $request)
    {

    }

    /**
     * function to logout a user
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'logout success',
            'success' => true
        ], 200);
    }

    /**
     * function to delete a user
     */
    public function delete(Request $request)
    {
        if (!(Hash::check($request->incomingPassword, $request->user()->password)))
        {
            return response()->json([
                'message' => 'Incorrect Passowrd',
                'success' => false
            ]);
        }

        $request->user()->tokens()->delete();
        $request->user()->delete();

        return response()->json([
            'message' => 'User deleted',
            'success' => true
        ], 200);
    }
}
