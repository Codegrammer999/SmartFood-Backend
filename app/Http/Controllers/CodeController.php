<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Code;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CodeController extends Controller
{
    public function create(Request $request)
    {
        $data = Validator::make($request->all(), [
            'payment_receipt' => 'required|string'
        ]);

        if ($request->user()->ownedCodes)
        {
            if ($request->user()->ownedCodes->count() === 5)
            {
                return response()->json([
                    'message' => 'Maximum purchasable codes reached',
                    'success' => false
                ], 401);
            }
        }

        $receipt = $request->payment_receipt;
        $ex = explode(',', $receipt);
        $imageData = base64_decode($ex[1]);

        $extension = str_contains($ex[0], 'jpeg') ? 'jpg' : 'png';
        $imageName = time() . '.' . $extension;
        $imagePath = 'payments/' . $imageName;

        Storage::disk('public')->put($imagePath, $imageData);
        $imageUrl = asset('storage/' . $imagePath);

        $code = Code::create([
            'code' => Code::generateUniqueCode(),
            'user_id' => $request->user()->id,
            'value' => 5000,
            'expires_at' => now()->addDays(15),
            'payment_receipt' => $imageUrl
        ]);

        return response()->json([
            'message' => 'New code successful',
            'success' => true
        ], 200);
    }

    public function getUserCodes(Request $request)
    {
        $codes = $request->user()->ownedCodes;

        return response()->json($codes, 200);
    }

    public function verifyRegistrationCode(Request $request)
    {
        $data = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'code' => 'required|string|max:20'
        ]);

        $user = User::find($request->user_id);

        if (!$user)
        {
            return response()->json([
                'message' => 'Please create an account first',
                'success' => false
            ], 401);
        }

        $code = Code::where('code', $request->code)->first();

        if ($code->status !== 'Activated')
        {
            return response()->json([
                'message' => 'Code has not been activated',
                'success' => false
            ], 400);
        }

        if (!$code || now()->greaterThan($code->expires_at))
        {
            return response()->json([
                'message' => 'Code is invalid or expired',
                'success' => false
            ], 400);
        }

        if ($code->is_redeemed)
        {
            $userWhoUsedCode = User::find($code->used_by);

            return response()->json([
                'message' => 'Code has already been used by ' . $userWhoUsedCode->username,
                'success' => false
            ], 400);
        }

        $code->is_redeemed = true;
        $code->redeemed_at = now();
        $code->used_by = $user->id;
        $code->status = 'Used';

        $user->registration_status = 'confirmed';
        $user->bonusWallet()->create([
            'balance' => $code->value
        ]);
        //$owner->notify(new CodeRedeemedNotification($user, $code)); for notifications later
        $user->save();
        $code->save();

        return response()->json([
            'message' => 'Code used successfully',
            'success' => true
        ], 200);
    }
}
