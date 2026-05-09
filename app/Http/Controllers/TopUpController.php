<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TopUpController extends Controller
{
    public function createOrder(Request $request)
    {
        try {
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
                'status' => OrderStatus::PENDING->value,
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

    public function triggerCallback(Request $request)
    {
        try {
            $validated = $request->validate([
                'reference_id' => 'required|max:64|exists:orders,reference_id',
                'callback_status' => [
                    'required',
                    Rule::enum(OrderStatus::class)->only([
                        OrderStatus::SUCCESS,
                        OrderStatus::FAILED,
                    ]),
                ]
            ]);

            // TODO: call main callback
            // TODO: turn callback calling into an async job
            // so it can run in the background
            // EXPLANATION:
            // we are faking a request to ensure this code can run
            // in single-thread server.
            // In real scenario, the trigger and the callback should
            // be in a different app
            $fakeRequest = Request::create(
                '/api/game/topup/callback',
                'POST',
                [],
                [],
                [],
                $_SERVER,
                json_encode([
                    ...$validated,
                    'callback_message' => 'Top-up simulation completed',
                ])
            );
            app()->handle($fakeRequest);

            return successResponse($validated, 'Callback trigger proccessed');
        } catch (ValidationException $e) {
            $validator = $e->validator;
            return validationErrorResponse($validator->errors()->toArray());
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return serverErrorResponse();
        }
    }

    public function callback(Request $request)
    {

    }
}
