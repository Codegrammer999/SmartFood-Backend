<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $menu = Menu::findorfail($request->menuId);

        if (!$menu || $menu->price != $request->price) {
            return response()->json([
                'message' => 'Invalid menu or menu details'
            ], 400);
        }

        $order = $request->user()->orders()->create([
            'menu_id' => $menu->id,
            'quantity' => $request->quantity,
            'total_price' => $menu->price * $request->quantity
        ]);

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order
        ]);
    }
}
