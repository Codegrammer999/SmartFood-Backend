<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $orders = $request->orders[0]['items'] ?? null;

        if (!$orders) {
            return response()->json(['error' => 'Invalid order data structure'], 400);
        }

        // Add extracted items back into the request for validation
        $request->merge(['orders' => $orders]);

        // Validate each item in orders
        $validator = Validator::make($request->all(), [
            'payment_receipt' => 'required|string',
            'orders' => 'required|array|min:1',
            'orders.*.id' => 'required|integer',
            'orders.*.quantity' => 'required|integer',
            'orders.*.price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
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

        // Initialize total order price
        $totalOrderPrice = 0;

        // Save each item in the orders array
        foreach ($orders as $order) {
            $orderPrice = $order['price'] * $order['quantity']; // Calculate total for the item
            $totalOrderPrice += $orderPrice; // Update total price for the entire order

            // Save each individual order item in the database
            $request->user()->orders()->create([
                'menu_id' => $order['id'],
                'menu_name' => $order['name'],
                'quantity' => $order['quantity'],
                'total_price' => $orderPrice,
                'payment_receipt' => $imageUrl
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function getOrders(Request $request)
    {
        if ($request->input('query') === 'all')
        {
            $orders = $request->user()->orders()->select('id', 'status', 'menu_name', 'total_price', 'quantity', 'created_at')->get();

            return response()->json($orders, 200);
        }

        $orders = $request->user()->orders()->select('id', 'status', 'menu_name', 'total_price', 'quantity', 'created_at')->where('status', $request->input('query'))->get();

        return response()->json($orders, 200);
    }
}
