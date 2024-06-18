<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Jobs\ProcessOrder;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'order_value' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        }

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'order_value' => $request->order_value,
            'process_id' => rand(1, 10)
        ]);

        $processId = $order->process_id;

        // Dispatch the job to process the order
        ProcessOrder::dispatch($order);

        $response = [
            'order_id' => $order->id,
            'process_id' => $order->process_id,
            'status' => 'success',
        ];

        return response()->json($response);

    }
}
