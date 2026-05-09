<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TopUpController extends Controller
{
    public function createOrder(Request $request)
    {
        try {
            // reject if request body is not a valid JSON
            if (!json_validate($request->getContent())) {
                return rejectedResponse('Request body must be a valid JSON');
            }

            $validated = $request->validate([
                'user_id' => 'required|numeric|gt:0',
                'game_code' => 'required|max:32',
                'reference_id' => 'required|max:64',
                'amount' => 'required|numeric|gt:0'
            ]);

            // reject if game code not available
            if (
                !Product::where('code', $validated['game_code'])
                    ->exists()
            ) {
                return rejectedResponse('Game code not found');
            }

            // reject if there is an order with the same 
            // reference id created in the last 10 seconds
            if (
                Order::where('reference_id', $validated['reference_id'])
                    ->where('created_at', '>', Carbon::now()->subSeconds(10))
                    ->exists()
            ) {
                return rejectedResponse('Duplicate reference_id detected within 10 seconds');
            }

            $order = Order::create([
                'order_id' => Order::createOrderId(),
                'user_id' => $validated['user_id'],
                'reference_id' => $validated['reference_id'],
                'game_code' => $validated['game_code'],
                'amount' => $validated['amount'],
                'status' => 'pending',
            ]);

            return successResponse(
                [
                    'order_id' => $order->order_id,
                    'reference_id' => $order->reference_id,
                    'order_status' => $order->status,
                ],
                'Order created successfully'
            );
        } catch (ValidationException $e) {
            $validator = $e->validator;
            return validationErrorResponse($validator->errors()->toArray());
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return serverErrorResponse();
        }
    }
}
