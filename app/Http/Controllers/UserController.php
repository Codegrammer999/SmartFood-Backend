<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user(Request $request)
    {
        $user = $request->user();

        return response()->json(array_merge(
            $user->toArray(),

            [
                'bonusWallet' => $user->bonusWallet->balance ?? null,
                'mainWallet' => $user->mainWallet->balance ?? null,
                'total_codes' => $user->ownedCodes->count() ?? null,
                'used_codes' => $user->usedCodes->count() ?? null
            ]
        ));
    }
}
