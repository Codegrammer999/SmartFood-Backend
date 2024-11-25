<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            'username' => 'required|string|unique:users|min:5|max:20',
            'email' => 'required|email|unique:users',
            'referral_id' => 'nullable|exists:users,referral_id|string|max:10',
            'password' => 'required|min:5|max:255|confirmed'
        ]);

        if ($data->fails())
        {
            return response()->json([
                'errors' => $data->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->referred_by = null;
        $user->role = 'user';
        $user->save();

        if (!empty($request->referral_id))
        {
            $referrer = User::where('referral_id', $request->referral_id)->first();

            if ($referrer)
            {
                $user->referred_by = $referrer->id;
                $user->save();

                Referral::create([
                    'referrer_id' => $referrer->id,
                    'referred_user_id' => $user->id,
                ]);
            }
        }

        DB::commit();

        return response()->json([
            'message' => 'New user created',
            'success' => true,
            'user_id' => $user->id
        ], 201);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
                'success' => false
            ], 500);
        }
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

        if ($user->registration_status !== 'confirmed')
        {
            return response()->json([
                'status' => 'Unconfirmed',
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

    public function submitPaymentReceipt(Request $request)
    {
        $data = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'payment_receipt' => 'required|string'
        ]);

        if ($data->fails())
        {
            return response()->json([
                'errors' => $data->errors()
            ], 422);
        }

        $user = User::find($request->user_id);

        if (!$user)
        {
            return response()->json([
                'message' => 'Please create an account first',
                'success' => false
            ], 404);
        }

        if ($user->payment_receipt === 'paid')
        {
            return response()->json([
                'message' => 'User has already paid',
                'success' => false
            ], 400);
        }

        // Decode and store the payment receipt image
        $receipt = $request->payment_receipt;
        $ex = explode(',', $receipt);
        $imageData = base64_decode($ex[1]);

        $extension = str_contains($ex[0], 'jpeg') ? 'jpg' : 'png';
        $imageName = time() . '.' . $extension;
        $imagePath = 'payments/' . $imageName;

        Storage::disk('public')->put($imagePath, $imageData);
        $imageUrl = asset('storage/' . $imagePath);

        $user->payment_receipt = $imageUrl;
        $user->save();

        return response()->json([
            'message' => 'Payment received sucessfully',
            'success' => true
        ], 200);
    }
}
